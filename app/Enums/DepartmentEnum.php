<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DepartmentEnum extends Enum
{
    public const OPTION_ONE =   0;
    public const OPTION_TWO =   1;
    public const OPTION_THREE = 2;
}
