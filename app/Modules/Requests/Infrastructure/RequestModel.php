<?php

namespace Modules\Requests\Infrastructure;

use CodeIgniter\Model;

class RequestModel extends Model
{
    protected $table          = 'contact_messages';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';

    protected $allowedFields = [
        'user_id',
        'type',
        'category',
        'subject',
        'message',
        'location',
        'status',
        'assigned_agent_id',
    ];

    protected $validationRules = [
        'user_id'  => 'required|integer',
        'type'     => 'required|in_list[contact,demande,signalement]',
        'message'  => 'required|min_length[10]',
        'status'   => 'required|in_list[nouveau,en_cours,traite]',
    ];
}