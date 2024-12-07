<?php

namespace CMW\Type\Redirect;

/**
 * Enum: @Utm
 * @package Redirect
 */
enum Utm
{
    case utm_source;
    case utm_campaign;
    case utm_medium;
    case utm_term;
    case utm_content;

    public static function fromName(string $name): self
    {
        foreach (self::cases() as $method) {
            if ($name === $method->name) {
                return $method;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum Utm");
    }

    public static function values(): array
    {
        return array_map(static fn($case) => $case->name, self::cases());
    }
}
