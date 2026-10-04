<?php

namespace Modules\Requests\Infrastructure;

use CodeIgniter\Model;

class RequestModel extends Model
{
    protected $table          = 'requests';
    protected $primaryKey     = 'id';
    protected $allowedFields  = [
        'citizen_id',
        'service_id',
        'type',
        'description',
        'location',
        'status',
        'agent_id',
    ];
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
    protected $validationRules = [
        'citizen_id'  => 'required|integer',
        'type'        => 'required|in_list[lampadaire,voirie,eau,dechets,espace_vert,autre]',
        'description' => 'required|min_length[10]',
        'status'      => 'required|in_list[nouveau,en_cours,resolu]',
    ];
}