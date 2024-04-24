<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Currency\Business\CurrencyFacade;

class ProductApiSchedulePriceImportToCurrencyFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Currency\Business\CurrencyFacade
     */
    protected MockObject|CurrencyFacade $currencyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    protected ProductApiSchedulePriceImportToCurrencyFacadeInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->currencyFacadeMock = $this->createMock(CurrencyFacade::class);
        $this->currencyTransferMock = $this->createMock(CurrencyTransfer::class);
        $this->bridge = new ProductApiSchedulePriceImportToCurrencyFacadeBridge($this->currencyFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetCurrent(): void
    {
        $this->currencyFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrent')
            ->willReturn($this->currencyTransferMock);

        static::assertEquals($this->currencyTransferMock, $this->bridge->getCurrent());
    }

    /**
     * @return void
     */
    public function testFindCurrencyByIsoCode(): void
    {
        $this->currencyFacadeMock->expects(static::atLeastOnce())
            ->method('findCurrencyByIsoCode')
            ->with('EUR')
            ->willReturn($this->currencyTransferMock);

        static::assertEquals($this->currencyTransferMock, $this->bridge->findCurrencyByIsoCode('EUR'));
    }
}
