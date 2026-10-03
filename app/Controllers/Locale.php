<?php

namespace App\Controllers;

class Locale extends BaseController
{
    public function switch(string $lang)
    {
        if (in_array($lang, ['fr', 'en'], true)) {
            session()->set('lang', $lang);
        }
        return redirect()->back();
    }
}