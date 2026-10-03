<?php

namespace App\Libraries;

/**
 * Appelle l'API officielle Nova Terra côté serveur (la clé reste dans .env)
 * et garde la réponse 60 s en cache. En cas de panne, renvoie la dernière copie connue.
 */
class NovaTerraClient
{
    private const FRESH_KEY = 'nova_requests_fresh';
    private const LAST_KEY  = 'nova_requests_last';
    private const FRESH_TTL = 60;
    private const LAST_TTL  = 86400;

    /**
     * @return array{session: array, requests: array, stale: bool}
     * @throws \RuntimeException si l'API est indisponible et qu'aucun cache n'existe
     */
    public function get(): array
    {
        $fresh = cache()->get(self::FRESH_KEY);
        if (is_array($fresh)) {
            return $fresh + ['stale' => false];
        }

        try {
            $payload = $this->call();
            cache()->save(self::FRESH_KEY, $payload, self::FRESH_TTL);
            cache()->save(self::LAST_KEY, $payload, self::LAST_TTL);

            return $payload + ['stale' => false];
        } catch (\Throwable $e) {
            log_message('error', 'Nova Terra API : ' . $e->getMessage());

            $last = cache()->get(self::LAST_KEY);
            if (is_array($last)) {
                return $last + ['stale' => true];
            }

            throw new \RuntimeException('API Nova Terra indisponible.', 0, $e);
        }
    }

    private function call(): array
    {
        $key = (string) env('NOVA_API_KEY', '');
        $url = (string) env('NOVA_API_URL', 'https://24h.webcup.fr/wp-json/webcup/v1/requests');

        if ($key === '') {
            throw new \RuntimeException('NOVA_API_KEY manquante dans .env');
        }

        $client   = service('curlrequest', ['timeout' => 8, 'http_errors' => false]);
        $response = $client->get($url, [
            'headers' => ['X-Webcup-Api-Key' => $key, 'Accept' => 'application/json'],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Réponse HTTP ' . $response->getStatusCode());
        }

        $json = json_decode((string) $response->getBody(), true);
        if (! is_array($json) || ! isset($json['requests']) || ! is_array($json['requests'])) {
            throw new \RuntimeException('Réponse JSON inattendue');
        }

        return [
            'session'  => is_array($json['session'] ?? null) ? $json['session'] : [],
            'requests' => $json['requests'],
        ];
    }
}
