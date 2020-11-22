<?php


namespace App\Entity\Constants;


class FrameSize
{
    public const SIZE_S = "S";
    public const SIZE_SM = "SM";
    public const SIZE_M = "M";
    public const SIZE_ML = "ML";
    public const SIZE_L = "L";
    public const SIZE_XL = "XL";
    public const SIZE_XXL = "XXL";

    public static function values() {
        return [
            self::SIZE_S,
            self::SIZE_SM,
            self::SIZE_M,
            self::SIZE_ML,
            self::SIZE_L,
            self::SIZE_XL,
            self::SIZE_XXL
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
