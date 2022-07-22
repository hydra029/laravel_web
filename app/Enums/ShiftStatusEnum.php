<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ShiftStatusEnum extends Enum
{
	public const Inactive = 1;
	public const Active = 2;
	public const TimeOut = 3;
}
