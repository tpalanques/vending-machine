<?php

namespace app\Ports\Out;

use app\Application\input\KeyboardString;
use app\Ports\Out\Input as iInput;

class InputFactory {
    public static function getKeyboardString(): iInput {
        return new KeyboardString();
    }
}
