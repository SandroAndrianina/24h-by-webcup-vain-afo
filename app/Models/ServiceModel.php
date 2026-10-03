<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table         = 'services';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'short_description', 'details', 'icon'];

    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;
}
