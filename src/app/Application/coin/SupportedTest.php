<?php

namespace app\Application\coin;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SupportedTest extends TestCase {

    private Supported $sut;

    public function __construct(string $name) {
        parent::__construct($name);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->sut = new Supported();
    }

    #[DataProvider('supportedValue')]
    public function testSupportedValue(float $value): void {
        $this->assertTrue($this->sut->isSupported($value));
    }

    #[DataProvider('unsupportedValue')]
    public function testNonSupported(float $supported): void {
        $this->assertFalse($this->sut->isSupported($supported));
    }

    public static function supportedValue(): array {
        return [[0.05], [0.10], [0.25], [1]];
    }

    public static function unsupportedValue(): array {
        return [[0], [0.01], [0.15], [0.30], [0.50]];
    }
}
