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

    // それぞれのUI用の値をオーバーライド（親クラス書き換え）
    public static function getDescription($value):string
    {
        if ($value === self::with_answer) {
            return "回答必須";
        }

        if ($value === self::sentense) {
            return "回答は文章";
        }

        return parent::getDescription($value);
    }

    // UI用の値の全て
    public static function getDescriptions(){
        return [0=>"回答必須",1=>"回答は文章"];
    }

    // それぞれのUI用の表示→SQL用の値→キーの返しをオーバーライド（親クラス書き換え）
    public static function getValue(string $key):mixed
    {
        if ($key === '回答必須') {
            return self::with_answer;
        }

        if ($key === '回答は文章') {
            return self::sentense;
        }

        return parent::getValue($key);
    }

    // getValues()で数値の全てを返すのはそのまま


}
