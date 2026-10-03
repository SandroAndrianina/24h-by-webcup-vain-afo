<?php

namespace App\Models;

use CodeIgniter\Model;

class CitizenContactModel extends Model
{
    protected $table          = 'contact_messages';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $allowedFields  = ['user_id', 'message', 'status'];
}
