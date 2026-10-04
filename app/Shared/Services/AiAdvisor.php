<?php

namespace App\Shared\Services;

class AiAdvisor
{
    private const CACHE_TTL = 86400;
    private const MODEL     = 'nvidia/nemotron-3-ultra-550b-a55b:free';

    /**
     * @return array{tips: array<string>, model: string, time_ms: int, cached: bool}
     */
    public static function forAlert(string $title, string $content, string $category, string $lang = 'fr', bool $force = false): array
    {
        $key   = 'advice_' . md5($lang . $category . $title);
        $cache = cache();

if (!$force) {
    $cached = $cache->get($key);
    if ($cached !== null && isset($cached['tips'])) {
        $cached['cached'] = true;
        return $cached;
    }
}

        $start  = microtime(true);
        $tips   = self::generate($title, $content, $category, $lang);
        $elapsed = (int) round((microtime(true) - $start) * 1000);

        $payload = [
            'tips'    => $tips,
            'model'   => self::MODEL,
            'time_ms' => $elapsed,
            'cached'  => false,
        ];

        $cache->save($key, $payload, self::CACHE_TTL);

        return $payload;
    }

    public static function forget(string $title, string $category, string $lang = 'fr'): void
    {
        cache()->delete('advice_' . md5($lang . $category . $title));
    }

    private static function generate(string $title, string $content, string $category, string $lang): array
    {
        $prompt = "Alerte municipale — catégorie : {$category}\n"
                . "Titre : {$title}\n"
                . "Description : {$content}\n\n"
                . "Génère exactement 4 conseils pratiques courts pour les habitants. "
                . "Réponds UNIQUEMENT par les 4 conseils, séparés par le caractère '|'. "
                . "Pas de numérotation, pas de préambule. Langue : " . ($lang === 'en' ? 'anglais' : 'français') . ". "
                . "Varie la formulation (seed: " . random_int(1000, 9999) . ").";

        $raw = self::callApi($prompt);
        if (!$raw) return self::fallback($lang);

        $parts = array_map('trim', explode('|', $raw));
        $parts = array_values(array_filter($parts, fn($p) => $p !== ''));
        $parts = array_slice($parts, 0, 4);

        return count($parts) >= 2 ? $parts : self::fallback($lang);
    }

    private static function fallback(string $lang): array
    {
        if ($lang === 'en') {
            return [
                'Stay hydrated and avoid direct sun between 11am and 4pm.',
                'Check on elderly neighbours and young children.',
                'Keep your home cool and close shutters during the day.',
                'Call emergency services in case of dizziness or discomfort.',
            ];
        }
        return [
            'Buvez régulièrement de l\'eau, évitez le soleil entre 11h et 16h.',
            'Prenez des nouvelles des personnes âgées et des jeunes enfants.',
            'Gardez votre logement frais et fermez les volets en journée.',
            'Appelez les secours en cas de vertige ou de malaise.',
        ];
    }

    private static function callApi(string $prompt): ?string
    {
        $key = env('OPENROUTER_API_KEY');
        if (!$key) return null;

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $key,
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'model'       => self::MODEL,
                'temperature' => 1,
                'messages'    => [
                    ['role' => 'system', 'content' => 'Tu es un assistant municipal concis.'],
                    ['role' => 'user',   'content' => $prompt],
                ],
            ]),
        ]);
        $raw = curl_exec($ch);
        curl_close($ch);

        if (!$raw) return null;

        $data = json_decode($raw, true);
        return $data['choices'][0]['message']['content'] ?? null;
    }
}