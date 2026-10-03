<?php

namespace App\Models;

use CodeIgniter\Model;

class CitizenRequestModel extends Model
{
    protected $table          = 'requests';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $allowedFields  = ['user_id', 'type', 'title', 'description', 'location', 'status'];

    public const TYPES = [
        'eclairage' => 'Éclairage public',
        'voirie'    => 'Voirie / route',
        'eau'       => 'Eau / fuite',
        'dechets'   => 'Déchets / propreté',
        'transport' => 'Transport',
        'autre'     => 'Autre',
    ];

    public const STATUS = [
        'nouveau'  => 'Envoyée',
        'en_cours' => 'En cours de traitement',
        'traite'   => 'Traitée',
    ];

    /** Historique : uniquement les demandes de CE citoyen */
    public function forUser(int $userId): array
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
    }

    /** Une demande, seulement si elle appartient a ce citoyen */
    public function findForUser(int $id, int $userId): ?array
    {
        return $this->where('id', $id)->where('user_id', $userId)->first();
    }
}
