<?php


namespace App\Entity\Constants;


class Material
{
    public const CARBON = "carbon";
    public const ALU = "alu";
    public const MIXED = "mixed";
    public const OTHER = "other";


    public static function values() {
        return [
            self::CARBON,
            self::ALU,
            self::MIXED,
            self::OTHER
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
