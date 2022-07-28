<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ShiftEnum extends Enum
{
	public const MORNING = 1;
	public const AFTERNOON = 2;
	public const EVENING = 3;

	public static function getArrayView(): array
	{
		return [
			'Morning'  => self::MORNING,
			'Afternoon'  => self::AFTERNOON,
			'Evening' => self::EVENING,
		];
	}

	public static function getKeyByValue($value): string
	{
		return array_search($value, self::getArrayView(), true);
	}
}
