<?php

use App\Shared\Services\AiTranslator;

if (!function_exists('t_content')) {
    function t_content(?string $text): string
    {
        if (empty($text)) return '';

        $lang = session()->get('lang') ?? 'fr';
        if ($lang === 'fr') return $text;

        return AiTranslator::translate($text, $lang);
    }
}