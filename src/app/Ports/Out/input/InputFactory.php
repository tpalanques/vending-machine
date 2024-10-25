<?php

namespace app\Ports\Out\input;

use app\Application\input\KeyboardString;
use app\Ports\Out\input\Input as iInput;

class InputFactory {
    public static function getKeyboardString(): iInput {
        return new KeyboardString();
    }
}
