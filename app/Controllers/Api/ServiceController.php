<?php

namespace App\Controllers\Api;

use App\Libraries\Format;
use App\Models\ServiceModel;
use CodeIgniter\HTTP\ResponseInterface;

class ServiceController extends BaseApiController
{
    private const RULES = [
        'name'             => 'required|max_length[150]',
        'shortDescription' => 'required|max_length[255]',
        'details'          => 'permit_empty',
        'icon'             => 'permit_empty|max_length[50]',
    ];

    /** GET /api/services */
    public function index(): ResponseInterface
    {
        $rows = (new ServiceModel())->orderBy('id', 'ASC')->findAll();

        return $this->json(['items' => array_map([Format::class, 'service'], $rows)]);
    }

    /** GET /api/services/{id} */
    public function show($id = null): ResponseInterface
    {
        $row = (new ServiceModel())->find((int) $id);

        return $row ? $this->json(Format::service($row)) : $this->notFound();
    }

    /** POST /api/services  (admin) */
    public function create(): ResponseInterface
    {
        $data = $this->clean($this->payload());
        if (! $this->validateData($data, self::RULES)) {
            return $this->validationError();
        }

        $model = new ServiceModel();
        $id    = $model->insert($this->toDb($data));

        return $this->json(Format::service($model->find($id)), 201);
    }

    /** PUT /api/services/{id}  (admin) */
    public function update($id = null): ResponseInterface
    {
        $model = new ServiceModel();
        if (! $model->find((int) $id)) {
            return $this->notFound();
        }

        $data = $this->clean($this->payload());
        if (! $this->validateData($data, self::RULES)) {
            return $this->validationError();
        }

        $model->update((int) $id, $this->toDb($data));

        return $this->json(Format::service($model->find((int) $id)));
    }

    /** DELETE /api/services/{id}  (admin, soft delete) */
    public function remove($id = null): ResponseInterface
    {
        $model = new ServiceModel();
        if (! $model->find((int) $id)) {
            return $this->notFound();
        }

        $model->delete((int) $id);

        return $this->json(['ok' => true]);
    }

    private function clean(array $in): array
    {
        return [
            'name'             => trim((string) ($in['name'] ?? '')),
            'shortDescription' => trim((string) ($in['shortDescription'] ?? '')),
            'details'          => (string) ($in['details'] ?? ''),
            'icon'             => trim((string) ($in['icon'] ?? '')),
        ];
    }

    private function toDb(array $d): array
    {
        return [
            'name'              => $d['name'],
            'short_description' => $d['shortDescription'],
            'details'           => $this->textOrNull($d['details']),
            'icon'              => $this->textOrNull($d['icon']),
        ];
    }
}
