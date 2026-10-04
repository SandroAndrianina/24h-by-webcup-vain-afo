<?php

namespace Modules\Requests\Application;

use Modules\Requests\Application\DTOs\SubmitRequestDTO;
use Modules\Requests\Domain\Entities\Request;
use Modules\Requests\Domain\Repositories\RequestRepositoryInterface;
use Modules\Requests\Domain\ValueObjects\RequestStatus;
use Modules\Requests\Domain\ValueObjects\RequestType;
use RuntimeException;

class SubmitRequest
{
    public function __construct(private RequestRepositoryInterface $requests) {}

    public function execute(SubmitRequestDTO $dto): Request
    {
        $description = trim($dto->description);
        if (mb_strlen($description) < 10) {
            throw new RuntimeException("La description doit contenir au moins 10 caractères.");
        }

        $request = new Request(
            null,
            $dto->citizenId,
            $dto->serviceId,
            new RequestType($dto->type),
            $description,
            $dto->location ? trim($dto->location) : null,
            new RequestStatus(RequestStatus::NOUVEAU),
            null,
            date('Y-m-d H:i:s'),
        );

        return $this->requests->save($request);
    }
}