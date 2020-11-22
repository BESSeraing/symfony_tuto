<?php


namespace App\Entity\Constants;


class WheelSize
{
    public const SIZE_12 = 12;
    public const SIZE_16 = 16;
    public const SIZE_20 = 20;
    public const SIZE_24 = 24;
    public const SIZE_26 = 26;
    public const SIZE_27_5 = 27.5;
    public const SIZE_28 = 28;
    public const SIZE_29 = 29;


    public static function values() {
        return [
            self::SIZE_12,
            self::SIZE_16,
            self::SIZE_20,
            self::SIZE_24,
            self::SIZE_26,
            self::SIZE_27_5,
            self::SIZE_28,
            self::SIZE_29
        ];
    }

    public static function formValues() {
        $formValues = [];
        foreach (self::values() as $value) {
            $formValues[$value] = $value;
        }

        return $formValues;
    }

}
