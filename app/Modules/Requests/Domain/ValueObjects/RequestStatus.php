<?php

namespace Modules\Requests\Domain\ValueObjects;

use InvalidArgumentException;

final class RequestStatus
{public const NOUVEAU  = 'nouveau';
public const EN_COURS = 'en_cours';
public const TRAITE   = 'traite';   // ← au lieu de RESOLU

private const VALID = [self::NOUVEAU, self::EN_COURS, self::TRAITE];

public function label(): string
{
    return match ($this->value) {
        self::NOUVEAU  => 'Nouveau',
        self::EN_COURS => 'En cours',
        self::TRAITE   => 'Traité',
    };
}

public function color(): string
{
    return match ($this->value) {
        self::NOUVEAU  => '#df9830',
        self::EN_COURS => '#3b82f6',
        self::TRAITE   => '#10b981',
    };
}

public function isResolved(): bool { return $this->value === self::TRAITE; }
}