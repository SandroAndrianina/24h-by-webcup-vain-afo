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

    /**
     * Nombre de publications non-alerte par mois sur les N derniers mois.
     * Sert de série pour le graphique du menu.
     *
     * @return array{labels: string[], series: int[]}
     */
    public function getPublishedTimeline(int $months = 6): array
    {
        $rows = $this->select('published_at')
                    ->where('published_at <=', date('Y-m-d H:i:s'))
                    ->where('is_alert', 0)
                    ->findAll();

        $short  = ['jan', 'fév', 'mar', 'avr', 'mai', 'jun', 'jul', 'aoû', 'sep', 'oct', 'nov', 'déc'];
        $labels = [];
        $series = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $stamp = strtotime("-{$i} months");
            $month = (int) date('n', $stamp);
            $labels[] = $short[$month - 1];
            $series[] = 0;
        }

        foreach ($rows as $row) {
            $index = array_search(substr((string) $row['published_at'], 0, 7), array_map(
                static fn (int $offset): string => date('Y-m', strtotime('-' . $offset . ' months')),
                range($months - 1, 0)
            ), true);

            if ($index !== false) {
                $series[$index]++;
            }
        }

        return ['labels' => $labels, 'series' => $series];
    }
}