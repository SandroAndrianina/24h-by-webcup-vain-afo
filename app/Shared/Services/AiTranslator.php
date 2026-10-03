<?php

namespace App\Shared\Services;

class AiTranslator
{
    private const CACHE_TTL    = 86400;
    private const LANG_MAP     = ['en' => 'en-GB', 'fr' => 'fr-FR'];
    private const MAX_CHARS    = 450;                 // limite safe MyMemory
    private const SEP_PATTERN  = '[[[%d]]]';          // token unique, non traduit

    private static bool $apiUnreachable = false;

    public static function translateBatch(array $texts, string $target = 'en'): array
    {
        if (empty($texts) || self::$apiUnreachable) return $texts;

        $cache  = cache();
        $result = [];
        $toTranslate = [];

        foreach ($texts as $key => $text) {
            $text = trim((string) $text);
            if ($text === '') { $result[$key] = ''; continue; }

            $ck = 'tr_' . md5($target . $text);
            $cached = $cache->get($ck);
            if ($cached !== null) {
                $result[$key] = $cached;
            } else {
                $toTranslate[$key] = $text;
            }
        }

        if (empty($toTranslate)) return $result;

        // Découper en lots respectant MAX_CHARS
        $batches = [];
        $current = [];
        $currentLen = 0;

        foreach ($toTranslate as $key => $text) {
            $len = mb_strlen($text) + 15; // marge pour le séparateur
            if ($currentLen + $len > self::MAX_CHARS && !empty($current)) {
                $batches[] = $current;
                $current = [];
                $currentLen = 0;
            }
            $current[$key] = $text;
            $currentLen += $len;
        }
        if (!empty($current)) $batches[] = $current;

        // Appel API par lot
        foreach ($batches as $batch) {
            $keys = array_keys($batch);
            $parts = [];
            foreach ($keys as $i => $k) {
                $parts[] = sprintf(self::SEP_PATTERN, $i) . "\n" . $batch[$k];
            }
            $joined = implode("\n", $parts);

            $translatedJoined = self::callApi($joined, $target);

            // Reconstruire avec regex sur les marqueurs
            $found = [];
            foreach ($keys as $i => $k) {
                $marker = sprintf(self::SEP_PATTERN, $i);
                $next   = sprintf(self::SEP_PATTERN, $i + 1);
                $pos = strpos($translatedJoined, $marker);
                if ($pos === false) continue;

                $start = $pos + strlen($marker);
                $end   = strpos($translatedJoined, $next, $start);
                $chunk = $end === false
                    ? substr($translatedJoined, $start)
                    : substr($translatedJoined, $start, $end - $start);
                $found[$k] = trim($chunk);
            }

            foreach ($keys as $k) {
                $original = $toTranslate[$k];
                $tr = $found[$k] ?? null;

                if (empty($tr) || $tr === $original) {
                    $result[$k] = $original; // fallback FR
                } else {
                    $result[$k] = $tr;
                    $cache->save('tr_' . md5($target . $original), $tr, self::CACHE_TTL);
                }
            }
        }

        return $result;
    }

    private static function callApi(string $text, string $target): string
    {
        $langpair = 'fr-FR|' . (self::LANG_MAP[$target] ?? 'en-GB');
        $email    = env('MYMEMORY_EMAIL', '');

        $params = ['q' => $text, 'langpair' => $langpair];
        if ($email) $params['de'] = $email;

        $url = 'https://api.mymemory.translated.net/get?' . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_CONNECTTIMEOUT => 5,
        ]);
        $raw   = curl_exec($ch);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($errno !== 0 || !$raw) {
            self::$apiUnreachable = true;
            return $text;
        }

        $data = json_decode($raw, true);
        $out  = $data['responseData']['translatedText'] ?? null;

        if (!$out || stripos($out, 'MYMEMORY WARNING') !== false) {
            return $text;
        }

        return $out;
    }
}