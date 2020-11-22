<?php


namespace App\Entity\Constants;


class FrameType
{
    public const FIX = "fix";
    public const HARD_TAIL = "hard_tail";
    public const FULL_SUSPENDED = "full_suspended";


    public static function values() {
        return [
            self::FIX,
            self::HARD_TAIL,
            self::FULL_SUSPENDED
        ];
    }

    public static function formValues() {
        return [
            self::FIX => self::FIX,
            self::HARD_TAIL => self::HARD_TAIL,
            self::FULL_SUSPENDED => self::FULL_SUSPENDED
        ];
    }

}
