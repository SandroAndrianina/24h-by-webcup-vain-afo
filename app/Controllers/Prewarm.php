<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;
use App\Models\ServiceModel;
use App\Shared\Services\AiTranslator;

class Prewarm extends BaseController
{
    public function index(string $lang = 'en'): \CodeIgniter\HTTP\ResponseInterface
    {
        if (!in_array($lang, ['en'], true)) {
            return $this->response->setJSON(['ok' => false, 'reason' => 'unsupported lang']);
        }

        // Services
        $services = (new ServiceModel())->findAll();
        $toTranslate = [];
        foreach ($services as $i => $s) {
            $toTranslate["s{$i}_name"] = $s['name'];
            $toTranslate["s{$i}_desc"] = $s['short_description'];
        }

        // Annonces
        $announcementModel = new AnnouncementModel();
        foreach ($announcementModel->getAllPublished() as $i => $a) {
            $toTranslate["a{$i}_title"] = $a['title'];
            $toTranslate["a{$i}_desc"]  = mb_substr(strip_tags($a['content']), 0, 140);
        }

        // Alerte active
        $activeAlert = $announcementModel->getActiveAlert();
        if ($activeAlert) {
            $toTranslate['alert_title'] = $activeAlert['title'];
            $toTranslate['alert_desc']  = mb_substr(strip_tags($activeAlert['content']), 0, 120);
        }

        AiTranslator::translateBatch($toTranslate, $lang);

        return $this->response->setJSON([
            'ok'      => true,
            'warmed'  => count($toTranslate),
        ]);
    }
}