<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactMessageModel extends Model
{
    protected $table = 'contact_messages';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'message',
        'status',
        'assigned_agent_id',
    ];

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $useSoftDeletes = true;

    protected $deletedField = 'deleted_at';
}