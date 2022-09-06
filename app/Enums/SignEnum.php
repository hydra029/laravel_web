<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SignEnum extends Enum
{
	public const ACCOUNTANT_SIGNED  = 1;
	public const CEO_SIGNED         = 2;
	public const EMPLOYEE_CONFIRMED = 3;

	public static function getArrayView(): array
	{
		return [
			'Accountant signed' => self::ACCOUNTANT_SIGNED,
			'CEO signed'        => self::CEO_SIGNED,
			'Employee signed'   => self::EMPLOYEE_CONFIRMED,
		];
	}

	public static function getKeyByValue($value): string
	{
		return array_search($value, self::getArrayView(), true);
	}
}