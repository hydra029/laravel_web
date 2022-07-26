<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ShiftStatusEnum extends Enum
{
	public const INACTIVE = 1;
	public const ACTIVE = 2;
	public const TIME_OUT = 3;

    public static function getArrayView(): array
    {
        return [
            'Inactive' => self::INACTIVE,
            'Active'  => self::ACTIVE,
            'Time Out' => self::TIME_OUT,
        ];
    }

    public static function getKeyByValue($value): string
    {
        return array_search($value, self::getArrayView(), true);
    }
}
