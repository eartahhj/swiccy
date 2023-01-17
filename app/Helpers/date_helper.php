
<?php
if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $date->format(_('m/d/Y H:i'));
    }
}