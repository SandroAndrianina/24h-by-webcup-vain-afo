<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class TerraNova extends BaseConfig
{
    public string $brand = 'TERRA NOVA';

    // ★ POUR CHANGER LES IMAGES : remplace les fichiers dans public/assets/images/
    //   (même nom) OU change les chemins ci-dessous (ou mets une URL https://...).
    public array $images = [
        'background' => 'assets/images/background.jpg', // fond plein écran
        'hero'       => 'assets/images/hero.jpg',       // photo du panneau gauche
    ];

    public string $heroPosition = 'center center';

    public array $links = [
        'signUp' => '#', 'joinUs' => '#',
        'linkedin' => 'https://www.linkedin.com', 'instagram' => 'https://www.instagram.com',
    ];

    public array $users = [];

    public function __construct()
    {
        parent::__construct();

        // Démo : designer@terranova.com / terranova123
        // → remplace par ton modèle CI4 (ex. UserModel) dans Auth::attempt()
        $this->users = [
            'designer@terranova.com' => ['name' => 'Designer', 'hash' => password_hash('terranova123', PASSWORD_DEFAULT)],
        ];
    }
}