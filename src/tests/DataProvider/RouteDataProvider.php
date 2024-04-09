<?php

namespace Tests\DataProvider;

class RouteDataProvider
{
    public static function passArgumentsToResolveMethod() : array
    {
        return [
            ['get', '/']
        ];
    }
}