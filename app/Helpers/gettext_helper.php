<?php

if (!function_exists('loadGettext')) {
    function loadGettext(string $language)
    {
        $domain = 'swiccy_' . $language;

        if (defined('LC_ALL')) {
            setlocale(LC_ALL, $language);
        }

        if (defined('LC_CTYPE')) {
            setlocale(LC_CTYPE, $language);
        }

        if (defined('LC_MESSAGES')) {
            setlocale(LC_MESSAGES, $language);
        }

        if (defined('LC_TIME')) {
            setlocale(LC_TIME, $language);
        }

        bindtextdomain($domain, APPPATH . 'Language/locale');
        textdomain($domain);
        bind_textdomain_codeset($domain, 'UTF-8');
    }
}
