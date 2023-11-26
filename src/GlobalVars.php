<?php

namespace LTL\Global;

use DomainException;
use ErrorException;

abstract class GlobalVars
{

    private static array $data = [];

    public static function __callStatic($method, $arguments)
    {
        if(!is_null($name = self::resolvePrefix('addOne', $method))) {
            self::addOne($name, ...$arguments);
           
            return;
        }

        if(!is_null($name = self::resolvePrefix('add', $method))) {
            self::add($name, ...$arguments);
           
            return;
        }

        if(!is_null($name = self::resolvePrefix('set', $method))) {
            self::set($name, ...$arguments);

            return;
        }

        try {
            return self::get($method, ...$arguments);
        } catch(ErrorException $exception) {
            throw new DomainException("Property {$method} was not initialized.");
        }
    }

    private static function resolvePrefix(string $prefix, string $name): string|null
    {
        if(str_starts_with($name, $prefix)) {
            return lcfirst(substr_replace($name, '', 0, strlen($prefix)));
        }
       
        return null;
    }

    private static function set(string $name, mixed $value): void
    {
        self::$data[static::class][$name] = $value;
    }

    private static function get(string $name): mixed
    {
        return self::$data[static::class][$name];
    }

    private static function add(string $name, int|float $amount): void
    {
        if(!array_key_exists($name, self::$data[static::class])) {
            self::$data[static::class][$name] = 0;
        }

        self::$data[static::class][$name] += $amount;
    }

    private static function addOne(string $name): void
    {
        self::add($name, 1);
    }

    public static function all(): array
    {
        return self::$data;
    }
}
