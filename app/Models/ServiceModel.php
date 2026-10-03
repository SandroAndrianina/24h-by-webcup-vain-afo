<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table          = 'services';
    protected $primaryKey     = 'id';
    protected $allowedFields  = ['name', 'short_description', 'details', 'icon', 'image'];
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
}