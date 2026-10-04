<?php

namespace Modules\Requests\Domain\ValueObjects;

use InvalidArgumentException;

final class RequestStatus
{
    public const NOUVEAU  = 'nouveau';
    public const EN_COURS = 'en_cours';
    public const RESOLU   = 'resolu';

    private const VALID = [self::NOUVEAU, self::EN_COURS, self::RESOLU];

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::VALID, true)) {
            throw new InvalidArgumentException("Statut invalide : $value");
        }
        $this->value = $value;
    }

    public function value(): string { return $this->value; }

    public function label(): string
    {
        return match ($this->value) {
            self::NOUVEAU  => 'Nouveau',
            self::EN_COURS => 'En cours',
            self::RESOLU   => 'Résolu',
        };
    }

    public function color(): string
    {
        return match ($this->value) {
            self::NOUVEAU  => '#df9830',   // orange
            self::EN_COURS => '#3b82f6',   // bleu
            self::RESOLU   => '#10b981',   // vert
        };
    }

    public function isResolved(): bool { return $this->value === self::RESOLU; }
}