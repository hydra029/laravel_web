<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class AttendanceEnum extends Enum
{
    public const CHECK  =   0;
    public const CHECKED =   1;

    public static function getArrayView(): array
    {
        return [
            'Check'  => self::CHECK,
            'Checked'  => self::CHECKED,
        ];
    }

    public static function getKeyByValue($value): string
    {
        return array_search($value, self::getArrayView(), true);
    }
}
