<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LocaleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $lang = session()->get('lang') ?? 'fr';
        if (!in_array($lang, ['fr', 'en'], true)) {
            $lang = 'fr';
        }
        \Config\Services::language()->setLocale($lang);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}