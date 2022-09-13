<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class EmpRoleEnum extends Enum
{
	public const EMPLOYEE = 1;
	public const MANAGER = 2;
	public const ACCOUNTANT = 3;
	public const CEO = 4;


    public static function getArrayView(): array
    {
        return [
            'employees'  => self::EMPLOYEE,
            'managers'  => self::MANAGER,
            'accountants' => self::ACCOUNTANT,
            'ceo' => self::CEO,
        ];
    }

    public static function getKeyByValue($value): string
    {
        return array_search($value, self::getArrayView(), true);
    }
}
