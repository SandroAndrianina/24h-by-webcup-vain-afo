<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;
use App\Shared\Services\AiTranslator;

class Announcements extends BaseController
{
    protected $helpers = ['url', 'i18n'];

    public function index(): string
    {
        $model = new AnnouncementModel();

        $announcements = $model->getAllPublished();
        $activeAlert   = $model->getActiveAlert();
        $lang = session()->get('lang') ?? 'fr';

        if ($lang !== 'fr' && !empty($announcements)) {
            $toTranslate = [];
            foreach ($announcements as $i => $a) {
                $toTranslate["a{$i}_title"] = $a['title'];
                $toTranslate["a{$i}_desc"]  = mb_substr(strip_tags($a['content']), 0, 140);
            }
            if ($activeAlert) {
                $toTranslate['alert_title'] = $activeAlert['title'];
                $toTranslate['alert_desc']  = mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }

            $tr = AiTranslator::translateBatch($toTranslate, $lang);

            foreach ($announcements as $i => &$a) {
                $a['title']        = $tr["a{$i}_title"] ?? $a['title'];
                $a['content_trim'] = $tr["a{$i}_desc"]  ?? mb_substr(strip_tags($a['content']), 0, 140);
            }
            unset($a);

            if ($activeAlert) {
                $activeAlert['title']        = $tr['alert_title'] ?? $activeAlert['title'];
                $activeAlert['content_trim'] = $tr['alert_desc']  ?? mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }
        } else {
            foreach ($announcements as &$a) {
                $a['content_trim'] = mb_substr(strip_tags($a['content']), 0, 140);
            }
            unset($a);
            if ($activeAlert) {
                $activeAlert['content_trim'] = mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }
        }

        return view('announcements/index', [
            'announcements' => $announcements,
            'activeAlert'   => $activeAlert,
        ]);
    }

    public function show(int $id): string
    {
        $model = new AnnouncementModel();
        $announcement = $model->find($id);

        if (!$announcement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $activeAlert = $model->getActiveAlert();
        $lang = session()->get('lang') ?? 'fr';

        $announcement['content_trim'] = mb_substr(strip_tags($announcement['content']), 0, 140);

        if ($lang !== 'fr') {
            $toTranslate = [
                'title'   => $announcement['title'],
                'content' => $announcement['content'],
            ];
            if ($activeAlert) {
                $toTranslate['alert_title'] = $activeAlert['title'];
                $toTranslate['alert_desc']  = mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }

            $tr = AiTranslator::translateBatch($toTranslate, $lang);

            $announcement['title']   = $tr['title']   ?? $announcement['title'];
            $announcement['content'] = $tr['content'] ?? $announcement['content'];

            if ($activeAlert) {
                $activeAlert['title']        = $tr['alert_title'] ?? $activeAlert['title'];
                $activeAlert['content_trim'] = $tr['alert_desc']  ?? mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }
        }

        if ($activeAlert && empty($activeAlert['content_trim'])) {
            $activeAlert['content_trim'] = mb_substr(strip_tags($activeAlert['content']), 0, 120);
        }

        return view('announcements/show', [
            'announcement' => $announcement,
            'activeAlert'  => $activeAlert,
        ]);
    }
}