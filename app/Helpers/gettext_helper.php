<?php

if (!function_exists('loadGettext')) {
    function loadGettext(string $language)
    {
        $domain = 'swiccy_' . $language;
        setlocale(LC_ALL, $language);
        bindtextdomain($domain, APPPATH . 'Language/locale');
        textdomain($domain);
        bind_textdomain_codeset($domain, 'UTF-8');
    }
}
