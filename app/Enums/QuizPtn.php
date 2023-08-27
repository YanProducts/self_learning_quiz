<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class QuizPtn extends Enum
{
    const with_answer = 0;
    const sentense = 1;

    // public static function getDescription($value)
    // {
    //     if ($value === self::with_answer) {
    //         return "回答必須";
    //     }

    //     if ($value === self::sentense) {
    //         return "回答は文章";
    //     }

    //     return parent::getDescription($value);
    // }

    // public static function getValue(string $key)
    // {
    //     if ($key === '回答必須') {
    //         return self::with_answer;
    //     }

    //     if ($key === '回答は文章') {
    //         return self::sentense;
    //     }

    //     return parent::getValue($key);
    // }

}
