<?php
namespace App\Modules\Requests\Infrastructure;

class RequestRepository
{
    private RequestModel $model;

    public function __construct()
    {
        $this->model = new RequestModel();
    }

    public function findByCitizen(int $userId): array
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereIn('type', ['demande','signalement'])
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function findOneForCitizen(int $id, int $userId): ?array
    {
        return $this->model
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function create(array $data): int
    {
        return $this->model->insert($data);
    }
}