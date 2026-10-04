<?php

namespace Modules\Requests\Domain\Repositories;

use Modules\Requests\Domain\Entities\Request;

interface RequestRepositoryInterface
{
    public function save(Request $request): Request;

    public function findById(int $id): ?Request;

    /** @return Request[] */
    public function findByCitizen(int $citizenId): array;

    /** @return Request[] */
    public function findAll(): array;

    public function updateStatus(int $id, string $status, ?int $agentId = null): bool;
}