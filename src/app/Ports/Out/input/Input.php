<?php

namespace app\Ports\Out\input;

interface Input {

    public function wait(): void;

    public function get(): string;
}
