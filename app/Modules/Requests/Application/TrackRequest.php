<?php

namespace Modules\Requests\Application;

use Modules\Requests\Domain\Entities\Request;
use Modules\Requests\Domain\Repositories\RequestRepositoryInterface;
use RuntimeException;

class TrackRequest
{
    public function __construct(private RequestRepositoryInterface $requests) {}

    public function execute(int $requestId, int $citizenId): Request
    {
        $request = $this->requests->findById($requestId);

        if ($request === null) {
            throw new RuntimeException("Demande introuvable.");
        }

        // Anti-IDOR : un citoyen ne voit que SES demandes
        if ($request->citizenId() !== $citizenId) {
            throw new RuntimeException("Accès refusé.");
        }

        return $request;
    }
}