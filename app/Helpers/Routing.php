<?php

namespace App\Helpers;

class Routing
{
    public static function getUrlTo(string $page): string {
        global $routes;
        return $routes->get($page)->getPath();
    }

    public static function getCustomUrlTo(string $page, array $parameters): string {
        global $generator;
        return $generator->generate($page, $parameters);
    }

    public static function redirectToURL(string $url) {
        header('Location: ' . $url);
    }

    public static function redirectToPage(string $page) {
        header('Location: ' . Routing::getUrlTo($page));
    }

    public static function redirectToCustomPage(string $page, array $parameters) {
        header('Location: ' . Routing::getCustomUrlTo($page, $parameters));
    }
}