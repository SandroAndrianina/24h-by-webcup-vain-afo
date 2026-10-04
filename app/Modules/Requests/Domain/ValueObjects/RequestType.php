<?php

namespace Modules\Requests\Domain\ValueObjects;

use InvalidArgumentException;

final class RequestType
{
    public const LAMPADAIRE = 'lampadaire';
    public const VOIRIE     = 'voirie';
    public const EAU        = 'eau';
    public const DECHETS    = 'dechets';
    public const ESPACE_VERT = 'espace_vert';
    public const AUTRE      = 'autre';

    private const VALID = [
        self::LAMPADAIRE,
        self::VOIRIE,
        self::EAU,
        self::DECHETS,
        self::ESPACE_VERT,
        self::AUTRE,
    ];

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::VALID, true)) {
            throw new InvalidArgumentException("Type de demande invalide : $value");
        }
        $this->value = $value;
    }

    public function value(): string { return $this->value; }

    public function label(): string
    {
        return match ($this->value) {
            self::LAMPADAIRE  => 'Éclairage public',
            self::VOIRIE      => 'Voirie',
            self::EAU         => 'Eau / assainissement',
            self::DECHETS     => 'Déchets',
            self::ESPACE_VERT => 'Espaces verts',
            self::AUTRE       => 'Autre',
        };
    }

    /** @return array<string,string> */
    public static function all(): array
    {
        $out = [];
        foreach (self::VALID as $v) {
            $out[$v] = (new self($v))->label();
        }
        return $out;
    }
}