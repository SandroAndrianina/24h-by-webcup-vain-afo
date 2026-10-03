<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;
use App\Models\ServiceModel;
use App\Shared\Services\AiTranslator;

class Service extends BaseController
{
    protected $helpers = ['url', 'i18n'];

    public function show(int $id): string
    {
        $service = (new ServiceModel())->find($id);

        if (!$service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $model = new AnnouncementModel();
        $activeAlert = $model->getActiveAlert();
        $lang = session()->get('lang') ?? 'fr';

        if ($lang !== 'fr') {
            $toTranslate = [
                'name'    => $service['name'],
                'short'   => $service['short_description'],
                'details' => $service['details'] ?? '',
            ];
            if ($activeAlert) {
                $toTranslate['alert_title'] = $activeAlert['title'];
                $toTranslate['alert_desc']  = mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }

            $tr = AiTranslator::translateBatch($toTranslate, $lang);

            $service['name']              = $tr['name']    ?? $service['name'];
            $service['short_description'] = $tr['short']   ?? $service['short_description'];
            $service['details']           = $tr['details'] ?? $service['details'];

            if ($activeAlert) {
                $activeAlert['title']        = $tr['alert_title'] ?? $activeAlert['title'];
                $activeAlert['content_trim'] = $tr['alert_desc']  ?? mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }
        } else {
            if ($activeAlert) {
                $activeAlert['content_trim'] = mb_substr(strip_tags($activeAlert['content']), 0, 120);
            }
        }

        return view('services/show', [
            'service'     => $service,
            'activeAlert' => $activeAlert,
        ]);
    }
}