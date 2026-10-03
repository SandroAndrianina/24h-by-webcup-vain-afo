<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Config\TerraNova;

class Auth extends BaseController
{
    public function index(): string
    {
        $cfg = config(TerraNova::class);

        // Ajoute ?v=<date du fichier> : une image remplacée s'affiche tout de suite.
        $images = [];
        foreach ($cfg->images as $key => $path) {
            if (str_starts_with($path, 'http')) {
                $images[$key] = $path;
                continue;
            }
            $file = FCPATH . ltrim($path, '/');
            $images[$key] = base_url($path) . (is_file($file) ? '?v=' . filemtime($file) : '');
        }

        return view('auth/login', ['page' => [
            'brand'        => $cfg->brand,
            'images'       => $images,
            'heroPosition' => $cfg->heroPosition,
            'links'        => $cfg->links,
            'loginUrl'     => site_url('login'),
            'csrfHeader'   => csrf_header(),
            'csrf'         => csrf_hash(),
        ]]);
    }

    public function attempt(): ResponseInterface
    {
        // 5 essais par minute et par IP
        if (! service('throttler')->check(md5($this->request->getIPAddress()), 5, MINUTE)) {
            return $this->reply(['ok' => false, 'error' => 'too_many_attempts'], 429);
        }

        try {
            $input = $this->request->getJSON(true);
        } catch (\Throwable) {
            $input = null;
        }
        $input    = is_array($input) ? $input : [];
        $email    = strtolower(trim((string) ($input['email'] ?? '')));
        $password = (string) ($input['password'] ?? '');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            return $this->reply(['ok' => false, 'error' => 'invalid_input'], 422);
        }

        $user = config(TerraNova::class)->users[$email] ?? null; // ← ton modèle ici

        if ($user === null || ! password_verify($password, $user['hash'])) {
            usleep(300000);

            return $this->reply(['ok' => false, 'error' => 'invalid_credentials'], 401);
        }

        session()->regenerate();
        session()->set('user', ['name' => $user['name'], 'email' => $email]);

        return $this->reply(['ok' => true, 'user' => ['name' => $user['name'], 'email' => $email]]);
    }

    private function reply(array $data, int $status = 200): ResponseInterface
    {
        $data['csrf'] = csrf_hash(); // nouveau jeton CSRF pour le prochain essai

        return $this->response->setStatusCode($status)->setJSON($data);
    }
}
