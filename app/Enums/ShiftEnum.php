<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ShiftEnum extends Enum
{
	public const Morning = 1;
	public const Afternoon = 2;
	public const Evening = 3;

	public static function getArrayView(): array
	{
		return [
			'Morning'  => self::Morning,
			'Afternoon'  => self::Afternoon,
			'Evening' => self::Evening,
		];
	}

	public static function getKeyByValue($value): string
	{
		return array_search($value, self::getArrayView(), true);
	}
}
