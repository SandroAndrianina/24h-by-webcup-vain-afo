<?php

namespace Modules\Requests\Application;

use Modules\Requests\Domain\Entities\Request;
use Modules\Requests\Domain\Repositories\RequestRepositoryInterface;

class ListCitizenRequests
{
    public function __construct(private RequestRepositoryInterface $requests) {}

    /** @return Request[] */
    public function execute(int $citizenId): array
    {
        return $this->requests->findByCitizen($citizenId);
    }
}