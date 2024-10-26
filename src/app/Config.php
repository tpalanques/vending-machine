<?php

namespace app;

class Config {
    public const int COIN_PRECISION = 2;
    // FIXME: this probably needs to be moved to Domain/Repository
    public const array STOCK = [
        'juice' => 3,
        'soda' => 5,
        'water' => 1
    ];
}
