<?php

namespace Modules\Requests\Domain\Entities;

use Modules\Requests\Domain\ValueObjects\RequestStatus;
use Modules\Requests\Domain\ValueObjects\RequestType;

final class Request
{
    public function __construct(
        private ?int $id,
        private int $citizenId,
        private ?int $serviceId,
        private RequestType $type,
        private string $description,
        private ?string $location,
        private RequestStatus $status,
        private ?int $agentId,
        private ?string $createdAt,
    ) {}

    public function id(): ?int { return $this->id; }
    public function citizenId(): int { return $this->citizenId; }
    public function serviceId(): ?int { return $this->serviceId; }
    public function type(): RequestType { return $this->type; }
    public function description(): string { return $this->description; }
    public function location(): ?string { return $this->location; }
    public function status(): RequestStatus { return $this->status; }
    public function agentId(): ?int { return $this->agentId; }
    public function createdAt(): ?string { return $this->createdAt; }

    public function withId(int $id): self
    {
        return new self(
            $id,
            $this->citizenId,
            $this->serviceId,
            $this->type,
            $this->description,
            $this->location,
            $this->status,
            $this->agentId,
            $this->createdAt,
        );
    }

    public function withStatus(RequestStatus $status): self
    {
        return new self(
            $this->id,
            $this->citizenId,
            $this->serviceId,
            $this->type,
            $this->description,
            $this->location,
            $status,
            $this->agentId,
            $this->createdAt,
        );
    }
}