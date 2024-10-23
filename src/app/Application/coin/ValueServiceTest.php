<?php

namespace app\Application\coin;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ValueServiceTest extends TestCase {

    private ValueService $sut;

    protected function setUp(): void {
        parent::setUp();
        $this->sut = new ValueService();
    }

    #[DataProvider('supported')]
    public function testSupportedValue(float $value): void {
        $this->assertTrue($this->sut->isSupported($value));
    }

    #[DataProvider('unsupported')]
    public function testNonSupportedValue(float $supported): void {
        $this->assertFalse($this->sut->isSupported($supported));
    }

    public static function supported(): array {
        return [[0.05], [0.10], [0.25], [1]];
    }

    public static function unsupported(): array {
        return [[0], [0.01], [0.15], [0.30], [0.50]];
    }
}
