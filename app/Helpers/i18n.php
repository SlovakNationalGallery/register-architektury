<?php

/**
* Get an associative array with localeCodes as keys and translated URLs of current page as value
*/
function getLocalizedURLArray($removeQueryString = true)
{
    $localesOrdered = LaravelLocalization::getLocalesOrder();
    $localizedURLs = [];
    foreach ($localesOrdered as $localeCode => $properties) {
        $url = LaravelLocalization::getLocalizedURL($localeCode, null, [], true);
        $pos = strpos($url, '?');
        if ($removeQueryString && $pos !== false) {
            $url = substr($url, 0, $pos);
        }
        $localizedURLs[$localeCode] = $url;
    }
    return $localizedURLs;
}