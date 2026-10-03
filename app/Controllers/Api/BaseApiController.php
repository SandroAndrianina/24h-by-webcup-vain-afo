<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

abstract class BaseApiController extends BaseController
{
    protected function userId(): int
    {
        return (int) session()->get('user_id');
    }

    protected function roleCode(): string
    {
        return (string) session()->get('role_code');
    }

    protected function payload(): array
    {
        try {
            $json = $this->request->getJSON(true);
        } catch (\Throwable $e) {
            $json = null;
        }

        return is_array($json) ? $json : (array) $this->request->getPost();
    }

    protected function json(array $payload, int $status = 200): ResponseInterface
    {
        return $this->response->setStatusCode($status)->setJSON($payload);
    }

    protected function error(string $message, int $status, array $fields = []): ResponseInterface
    {
        $payload = ['error' => $message];
        if ($fields) {
            $payload['fields'] = $fields;
        }

        return $this->json($payload, $status);
    }

    protected function notFound(): ResponseInterface
    {
        return $this->error('Ressource introuvable.', 404);
    }

    protected function validationError(): ResponseInterface
    {
        return $this->error('Données invalides.', 422, $this->validator->getErrors());
    }

    /** Date ISO 8601 reçue du front -> format SQL UTC (null si invalide) */
    protected function toDbDate(string $iso): ?string
    {
        try {
            return (new \DateTimeImmutable($iso))
                ->setTimezone(new \DateTimeZone('UTC'))
                ->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            return null;
        }
    }

    /** Texte nettoyé, ou null s'il est vide */
    protected function textOrNull($value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
