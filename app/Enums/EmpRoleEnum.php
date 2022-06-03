<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class EmpRoleEnum extends Enum
{
	public const Employee = 1;
	public const Manager = 2;
	public const Accountant = 3;
	public const Ceo = 4;
}
