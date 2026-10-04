<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;
use App\Models\ServiceModel;
use App\Shared\Services\AiAdvisor;
use App\Shared\Services\AiTranslator;

class Menu extends BaseController
{
    protected $helpers = ['url', 'i18n'];

    public function index(): string
    {
        $services = (new ServiceModel())->orderBy('id', 'ASC')->findAll();
        $announcementModel = new AnnouncementModel();
        $announcements = $announcementModel->getLatest(3);
        $activeAlert   = $announcementModel->getActiveAlert();

        $lang = session()->get('lang') ?? 'fr';

        if ($lang !== 'fr') {
            $toTranslate = [];
            foreach ($services as $i => $s) {
                $toTranslate["s{$i}_name"] = $s['name'];
                $toTranslate["s{$i}_desc"] = $s['short_description'];
            }
            foreach ($announcements as $i => $a) {
                $toTranslate["a{$i}_title"] = $a['title'];
                $toTranslate["a{$i}_desc"]  = mb_substr(strip_tags($a['content']), 0, 140);
            }
            if ($activeAlert) {
                $toTranslate['alert_title'] = $activeAlert['title'];
                $toTranslate['alert_desc']  = mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }

            $tr = AiTranslator::translateBatch($toTranslate, $lang);

            foreach ($services as $i => &$s) {
                $s['name']              = $tr["s{$i}_name"] ?? $s['name'];
                $s['short_description'] = $tr["s{$i}_desc"] ?? $s['short_description'];
            }
            unset($s);

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

        // ===== Recommandations IA pour l'alerte =====
        $forceRegen = (bool) $this->request->getGet('regen');

        $alertAdvice = null;
        if ($activeAlert) {
            $alertAdvice = AiAdvisor::forAlert(
                $activeAlert['title'],
                $activeAlert['content_trim'] ?? $activeAlert['content'],
                $activeAlert['alert_category'] ?? 'general',
                $lang,
                $forceRegen
            );
        }

        $items = [];
        foreach ($services as $i => $s) {
            $items[] = [
                'id'    => $s['id'],
                'num'   => str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'icon'  => $s['icon'] ?? 'orbit',
                'title' => $s['name'],
                'image' => base_url('assets/images/' . $s['image']),
                'text'  => $s['short_description'],
            ];
        }

        $menu = [
            'name'  => lang('App.home.title'),
            'items' => $items,
        ];

        return view('menu_page', [
            'menu'          => $menu,
            'announcements' => $announcements,
            'activeAlert'   => $activeAlert,
            'alertAdvice'   => $alertAdvice,
        ]);
    }

public function regenAlert()
{
    cache()->clean();
    dd('Cache vidé. Dossier : ' . WRITEPATH . 'cache');
}
}