<?php
use App\Models\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

if (!function_exists('getPageIdByUrl')) {
    function getPageIdByUrl(string $url, int $maxDigits = 10): int
    {
        if (!preg_match('/^([1-9]{1,' . $maxDigits . '})/', $url, $matches)) {
            return 0;
        }
    
        return $matches[0];
    }
}

if (!function_exists('getPageUrlById')) {
    function getPageUrlById(int $pageId): string
    {
        $locale = service('request')->getLocale();
        $routes = service('routes');
        $url = '';

        $reverseRoute = $routes->reverseRoute($locale . '.pages.show', $pageId);

        $pages = model(PageModel::class);
        $page = $pages->find($pageId);

        if (!$page) {
            return '#';
        }

        $url = $reverseRoute . '-' . $page->{'url_' . $locale};

        return $url;
    }
}

if (!function_exists('getPageUrlByUri')) {
    function getPageUrlByUri(string $uri, string $separator = '-'): string
    {
        if ($separator) {
            $position = stripos($uri, $separator);
            if (!$position) {
                return '';
            }

            return substr($uri, $position + strlen($separator));
        }
    }
}

if (!function_exists('isPageUrlFormatValid')) {
    function isPageUrlFormatValid(string $url, string $separator = '-', int $maxDigits = 10): bool
    {
        if ($separator) {
            if (!stripos($url, $separator)) {
                return false;
            }
        }

        if (!getPageIdByUrl($url, $maxDigits)) {
            return false;
        }

        if (!getPageUrlByUri($url, $separator)) {
            return false;
        }
    
        return true;
    }
}

if (!function_exists('page_url')) {
    function page_url($id)
    {
        return getPageUrlById(intval($id));
    }
}