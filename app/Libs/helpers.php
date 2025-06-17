<?php

if (!function_exists('get_svg')) {
    function get_svg(string $path, string $class = ''): false|string
    {
        $path = str_replace('.', '/', trim($path, "' "));
        $svg  = new \DOMDocument();
        $svg->load(public_path('icons/'.$path.'.svg'));
        $svg->documentElement->setAttribute("class", $class);
        return $svg->saveXML($svg->documentElement);
    }
}
