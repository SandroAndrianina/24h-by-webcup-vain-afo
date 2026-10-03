<?php

namespace App\Controllers\Api;

use App\Libraries\Format;
use App\Models\AnnouncementModel;
use CodeIgniter\HTTP\ResponseInterface;

class AnnouncementController extends BaseApiController
{
    private const RULES = [
        'title'       => 'required|max_length[200]',
        'content'     => 'required',
        'publishedAt' => 'permit_empty',
    ];

    /** GET /api/announcements */
    public function index(): ResponseInterface
    {
        $rows = $this->base()
            ->orderBy('announcements.published_at', 'DESC')
            ->orderBy('announcements.id', 'DESC')
            ->findAll();

        return $this->json(['items' => array_map([Format::class, 'announcement'], $rows)]);
    }

    /** GET /api/announcements/{id} */
    public function show($id = null): ResponseInterface
    {
        $row = $this->base()->find((int) $id);

        return $row ? $this->json(Format::announcement($row)) : $this->notFound();
    }

    /** POST /api/announcements  (admin) */
    public function create(): ResponseInterface
    {
        $data = $this->clean($this->payload());
        if (! $this->validateData($data, self::RULES)) {
            return $this->validationError();
        }

        $published = $this->publishedAt($data['publishedAt']);
        if ($published === false) {
            return $this->error('Données invalides.', 422, ['publishedAt' => 'Date invalide (format ISO 8601 attendu).']);
        }

        $model = new AnnouncementModel();
        $id    = $model->insert([
            'title'        => $data['title'],
            'content'      => $data['content'],
            'published_at' => $published ?? gmdate('Y-m-d H:i:s'),
            'author_id'    => $this->userId(), // jamais lu dans la requête
        ]);

        return $this->json(Format::announcement($this->base()->find($id)), 201);
    }

    /** PUT /api/announcements/{id}  (admin) */
    public function update($id = null): ResponseInterface
    {
        $model = new AnnouncementModel();
        if (! $model->find((int) $id)) {
            return $this->notFound();
        }

        $data = $this->clean($this->payload());
        if (! $this->validateData($data, self::RULES)) {
            return $this->validationError();
        }

        $published = $this->publishedAt($data['publishedAt']);
        if ($published === false) {
            return $this->error('Données invalides.', 422, ['publishedAt' => 'Date invalide (format ISO 8601 attendu).']);
        }

        $changes = ['title' => $data['title'], 'content' => $data['content']];
        if ($published !== null) {
            $changes['published_at'] = $published;
        }
        $model->update((int) $id, $changes);

        return $this->json(Format::announcement($this->base()->find((int) $id)));
    }

    /** DELETE /api/announcements/{id}  (admin, soft delete) */
    public function remove($id = null): ResponseInterface
    {
        $model = new AnnouncementModel();
        if (! $model->find((int) $id)) {
            return $this->notFound();
        }

        $model->delete((int) $id);

        return $this->json(['ok' => true]);
    }

    /**
     * Annonces + nom de l'auteur. Les non-admins ne voient pas les annonces
     * dont la date de publication est dans le futur.
     */
    private function base(): AnnouncementModel
    {
        $model = (new AnnouncementModel())
            ->select('announcements.*, users.name AS author_name')
            ->join('users', 'users.id = announcements.author_id', 'left');

        if ($this->roleCode() !== 'admin') {
            $model->where('announcements.published_at <=', gmdate('Y-m-d H:i:s'));
        }

        return $model;
    }

    private function clean(array $in): array
    {
        return [
            'title'       => trim((string) ($in['title'] ?? '')),
            'content'     => trim((string) ($in['content'] ?? '')),
            'publishedAt' => trim((string) ($in['publishedAt'] ?? '')),
        ];
    }

    /** null = absent, false = invalide, string = date SQL UTC */
    private function publishedAt(string $iso)
    {
        if ($iso === '') {
            return null;
        }

        return $this->toDbDate($iso) ?? false;
    }
}
