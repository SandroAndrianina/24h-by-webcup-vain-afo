<?php
namespace App\Modules\Requests\Application;

use App\Modules\Requests\Infrastructure\RequestRepository;

class ListCitizenRequests
{
    public function execute(int $userId): array
    {
        return (new RequestRepository())->findByCitizen($userId);
    }
}