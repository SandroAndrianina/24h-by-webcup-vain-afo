<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ServiceController extends BaseController
{
    // Nom d'icône (colonne services.icon) -> emoji affiché
    private const ICONS = [
        'file-text'      => '📄',
        'heart-pulse'    => '🩺',
        'building-2'     => '🏢',
        'bus'            => '🚌',
        'leaf'           => '🌿',
        'graduation-cap' => '🎓',
        'shield'         => '🛡️',
    ];

    /** GET /services  (et /menu y redirige) */
    public function index(): string
    {
        return view('public/services/index', [
            'title'    => 'Services de la ville',
            'services' => (new ServiceModel())->orderBy('id', 'ASC')->findAll(),
            'icons'    => self::ICONS,
        ]);
    }

    /** GET /services/{id} */
    public function show($id = null): string
    {
        $service = (new ServiceModel())->find((int) $id);
        if (! $service) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('public/services/show', [
            'title'   => $service['name'],
            'service' => $service,
            'icons'   => self::ICONS,
        ]);
    }
}
