<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\PriceTypeTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductScheduleMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected MockObject|ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToPriceProductFacadeBridge $priceProductFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected MockObject|MoneyValueTransfer $moneyValueTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceTypeTransfer
     */
    protected MockObject|PriceTypeTransfer $priceTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected MockObject|StoreTransfer $storeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToCurrencyFacadeBridge $currencyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToStoreFacadeBridge $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper
     */
    protected PriceProductScheduleMapper $priceProductScheduleMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiSchedulePriceImportConfigMock = $this->createMock(ProductApiSchedulePriceImportConfig::class);
        $this->priceProductFacadeMock = $this->createMock(ProductApiSchedulePriceImportToPriceProductFacadeBridge::class);
        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->priceProductTransferMock = $this->createMock(PriceProductTransfer::class);
        $this->moneyValueTransferMock = $this->createMock(MoneyValueTransfer::class);
        $this->priceTypeTransferMock = $this->createMock(PriceTypeTransfer::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);
        $this->currencyTransferMock = $this->createMock(CurrencyTransfer::class);
        $this->productConcreteTransferMock = $this->createMock(ProductConcreteTransfer::class);
        $this->currencyFacadeMock = $this->createMock(ProductApiSchedulePriceImportToCurrencyFacadeBridge::class);
        $this->storeFacadeMock = $this->createMock(ProductApiSchedulePriceImportToStoreFacadeBridge::class);

        $this->priceProductScheduleMapper = new PriceProductScheduleMapper(
            $this->priceProductFacadeMock,
            $this->apiSchedulePriceImportConfigMock,
            $this->currencyFacadeMock,
            $this->storeFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateFromProductAbstractTransfer(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->productAbstractTransferMock->expects(static::once())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 2500,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->currencyFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrent')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getCode')
            ->willReturn('EUR');

        $this->currencyFacadeMock->expects(static::atLeastOnce())
            ->method('findCurrencyByIsoCode')
            ->with('EUR')
            ->willReturn($this->currencyTransferMock);

        $this->storeFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->priceProductFacadeMock->expects(static::once())
            ->method('findPriceTypeByName')
            ->with(ProductApiSchedulePriceImportConstants::PRICE_DEFAULT)
            ->willReturn($this->priceTypeTransferMock);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getPriceDimensionRrp')
            ->willReturn(ProductApiSchedulePriceImportConstants::PRICE_DEFAULT);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getIdStore')
            ->willReturn(1);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCurrency')
            ->willReturn(99);

        $this->priceProductScheduleMapper->createFromProductAbstractTransfer(
            $this->productAbstractTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateFromProductConcreteTransfer(): void
    {
        $this->productConcreteTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductConcrete')
            ->willReturn(1);

        $this->productConcreteTransferMock->expects(static::once())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 2500,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->currencyFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrent')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getCode')
            ->willReturn('EUR');

        $this->currencyFacadeMock->expects(static::atLeastOnce())
            ->method('findCurrencyByIsoCode')
            ->with('EUR')
            ->willReturn($this->currencyTransferMock);

        $this->storeFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->priceProductFacadeMock->expects(static::once())
            ->method('findPriceTypeByName')
            ->with(ProductApiSchedulePriceImportConstants::PRICE_DEFAULT)
            ->willReturn($this->priceTypeTransferMock);

        $this->apiSchedulePriceImportConfigMock->expects(static::once())
            ->method('getPriceDimensionRrp')
            ->willReturn(ProductApiSchedulePriceImportConstants::PRICE_DEFAULT);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getIdStore')
            ->willReturn(1);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCurrency')
            ->willReturn(99);

        $this->priceProductScheduleMapper->createFromProductConcreteTransfer(
            $this->productConcreteTransferMock,
        );
    }
}
