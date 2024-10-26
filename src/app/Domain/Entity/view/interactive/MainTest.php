<?php

namespace app\Domain\Entity\view\interactive;

use app\Ports\In\coin\Factory as CoinFactory;
use app\Ports\In\coin\SetFactory as CoinSetFactory;
use app\Ports\In\machine\BuyService as iBuyService;
use app\Ports\In\stock\Stock as iStock;
use app\Ports\Out\input\Input as iInput;
use app\Ports\Out\view\Console as iConsole;
use app\Ports\Out\view\interactive\Interactive as iInteractiveView;
use app\Ports\Out\view\interactive\Factory as InteractiveViewFactory;
use app\Ports\In\processor\Processor as iProcessor;
use app\Ports\In\processor\Factory as ProcessorFactory;
use app\Ports\Out\view\Factory as ViewFactory;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase {

    private iInteractiveView $sut;

    protected function setUp(): void {
        parent::setUp();
        $factory = (new InteractiveViewFactory(
            $this->getProcessorFactoryMock(),
            $this->getViewFactoryMock(),
            $this->getInputMock(),
            (new CoinSetFactory())->createEmpty(),
            $this->getStockMock(),
            $this->getStockMock(),
            $this->getStockMock(),
            new CoinFactory(),
            $this->getBuyServiceMock()
        ));
        $this->sut = $factory->getMain();
    }

    public function testGetProcessor() {
        $this->assertEquals($this->getProcessorMock(), $this->sut->getProcessor());
        $this->assertEquals($this->getViewMock(), $this->sut->getView());
    }

    private function getProcessorFactoryMock(): ProcessorFactory {
        $mock = $this->createMock(ProcessorFactory::class);
        $mock->method('getMain')->willReturn($this->getProcessorMock());
        return $mock;
    }

    private function getProcessorMock(): iProcessor {
        return $this->createMock(iProcessor::class);
    }

    private function getViewFactoryMock(): ViewFactory {
        $mock = $this->createMock(ViewFactory::class);
        $mock->method('getMain')->willReturn($this->getViewMock());
        return $mock;
    }

    private function getViewMock(): iConsole {
        return $this->createMock(iConsole::class);
    }

    private function getInputMock(): iInput {
        return $this->createMock(iInput::class);
    }

    private function getStockMock(): iStock {
        return $this->createMock(iStock::class);
    }

    private function getBuyServiceMock(): iBuyService {
        return $this->createMock(iBuyService::class);
    }
}
