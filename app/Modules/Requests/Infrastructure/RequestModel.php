<?php
namespace App\Modules\Requests\Infrastructure;

use CodeIgniter\Model;

class RequestModel extends Model
{
    protected $table         = 'contact_messages';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'user_id','type','subject','message','location',
        'status','assigned_agent_id',
    ];
}