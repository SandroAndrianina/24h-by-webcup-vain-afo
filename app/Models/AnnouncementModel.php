<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table          = 'announcements';
    protected $primaryKey     = 'id';
    protected $allowedFields  = ['title', 'content', 'is_alert', 'published_at', 'author_id'];
    protected $returnType     = 'array';
    protected $useTimestamps  = false;
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';

    public function getLatest(int $limit = 3): array
    {
        return $this->where('published_at <=', date('Y-m-d H:i:s'))
                    ->where('is_alert', 0)
                    ->orderBy('published_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    public function getActiveAlert(): ?array
    {
        return $this->where('is_alert', 1)
                    ->where('published_at <=', date('Y-m-d H:i:s'))
                    ->orderBy('published_at', 'DESC')
                    ->first();
    }

    public function getAllPublished(): array
    {
        return $this->where('published_at <=', date('Y-m-d H:i:s'))
                    ->where('is_alert', 0)
                    ->orderBy('published_at', 'DESC')
                    ->findAll();
    }
}