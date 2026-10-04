<?php

namespace Modules\Requests\Application\DTOs;

final class SubmitRequestDTO
{
    public function __construct(
        public readonly int $citizenId,
        public readonly string $type,
        public readonly string $description,
        public readonly ?string $location = null,
        public readonly ?int $serviceId = null,
    ) {}
}