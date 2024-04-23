<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepository;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SalePriceHandlerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper
     */
    protected MockObject|PriceProductScheduleMapper $priceProductScheduleMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge $priceProductScheduleFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToCurrencyFacadeBridge $currencyFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeBridge
     */
    protected MockObject|ProductApiSchedulePriceImportToStoreFacadeBridge $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepository
     */
    protected MockObject|ProductApiSchedulePriceImportRepository $productApiSchedulePriceImportRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected MockObject|ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected MockObject|StoreTransfer $storeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    protected MockObject|PriceProductScheduleTransfer $priceProductScheduleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected MockObject|MoneyValueTransfer $moneyValueTransferMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceHandlerInterface
     */
    protected SalePriceHandlerInterface $salePriceHandler;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceProductScheduleMapperMock = $this->createMock(PriceProductScheduleMapper::class);
        $this->priceProductScheduleFacadeMock = $this->createMock(ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge::class);
        $this->currencyFacadeMock = $this->createMock(ProductApiSchedulePriceImportToCurrencyFacadeBridge::class);
        $this->storeFacadeMock = $this->createMock(ProductApiSchedulePriceImportToStoreFacadeBridge::class);
        $this->productApiSchedulePriceImportRepositoryMock = $this->createMock(ProductApiSchedulePriceImportRepository::class);
        $this->apiSchedulePriceImportConfigMock = $this->createMock(ProductApiSchedulePriceImportConfig::class);
        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->currencyTransferMock = $this->createMock(CurrencyTransfer::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);
        $this->priceProductScheduleTransferMock = $this->createMock(PriceProductScheduleTransfer::class);
        $this->priceProductTransferMock = $this->createMock(PriceProductTransfer::class);
        $this->moneyValueTransferMock = $this->createMock(MoneyValueTransfer::class);

        $this->salePriceHandler = new SalePriceHandler(
            $this->priceProductScheduleMapperMock,
            $this->priceProductScheduleFacadeMock,
            $this->currencyFacadeMock,
            $this->storeFacadeMock,
            $this->productApiSchedulePriceImportRepositoryMock,
            $this->apiSchedulePriceImportConfigMock,
        );
    }

    /**
     * @return void
     */
    public function testHandleProductAbstractInvalidAttributes(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => null,
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->currencyFacadeMock->expects(static::never())
            ->method('getCurrent');

        $productAbstractTransfer = $this->salePriceHandler->handleProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleProductAbstractCreateNew(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
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

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCurrency')
            ->willReturn(99);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getIdStore')
            ->willReturn(1);

        $this->productApiSchedulePriceImportRepositoryMock->expects(static::atLeastOnce())
            ->method('findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore')
            ->with(1, 99, 1)
            ->willReturn(null);

        $this->priceProductScheduleMapperMock->expects(static::atLeastOnce())
            ->method('createFromProductAbstractTransfer')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $productAbstractTransfer = $this->salePriceHandler->handleProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testHandleProductAbstractUpdate(): void
    {
        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
                ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
            ]);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
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

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCurrency')
            ->willReturn(99);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getIdStore')
            ->willReturn(1);

        $this->productApiSchedulePriceImportRepositoryMock->expects(static::atLeastOnce())
            ->method('findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore')
            ->with(1, 99, 1)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveFrom')
            ->willReturn('2024-03-01');

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveTo')
            ->willReturn('2025-01-01');

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getPriceProduct')
            ->willReturn($this->priceProductTransferMock);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn(2599);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceProductSchedule')
            ->willReturn(10);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('removeAndApplyPriceProductSchedule')
            ->with(10);

        $this->priceProductScheduleMapperMock->expects(static::atLeastOnce())
            ->method('createFromProductAbstractTransfer')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $productAbstractTransfer = $this->salePriceHandler->handleProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }
}
