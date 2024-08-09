<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepository;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SchedulePriceProductAbstractModelTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    protected MockObject|PriceProductScheduleTransfer $priceProductScheduleTransferMock;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\StoreTransfer
     */
    protected MockObject|StoreTransfer $storeTransferMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface
     */
    protected SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->priceProductScheduleTransferMock = $this->createMock(PriceProductScheduleTransfer::class);
        $this->priceProductScheduleMapperMock = $this->createMock(PriceProductScheduleMapper::class);
        $this->priceProductScheduleFacadeMock = $this->createMock(ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge::class);
        $this->currencyFacadeMock = $this->createMock(ProductApiSchedulePriceImportToCurrencyFacadeBridge::class);
        $this->storeFacadeMock = $this->createMock(ProductApiSchedulePriceImportToStoreFacadeBridge::class);
        $this->productApiSchedulePriceImportRepositoryMock = $this->createMock(ProductApiSchedulePriceImportRepository::class);
        $this->currencyTransferMock = $this->createMock(CurrencyTransfer::class);
        $this->storeTransferMock = $this->createMock(StoreTransfer::class);

        $this->schedulePriceProductAbstractModel = new SchedulePriceProductAbstractModel(
            $this->priceProductScheduleMapperMock,
            $this->priceProductScheduleFacadeMock,
            $this->currencyFacadeMock,
            $this->storeFacadeMock,
            $this->productApiSchedulePriceImportRepositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->priceProductScheduleMapperMock->expects(static::atLeastOnce())
            ->method('createFromProductAbstractTransfer')
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $this->schedulePriceProductAbstractModel->create($this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getIdPriceProductSchedule')
            ->willReturn(1);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('removeAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock->getIdPriceProductSchedule());

        $this->priceProductScheduleMapperMock->expects(static::atLeastOnce())
            ->method('createFromProductAbstractTransfer')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->priceProductScheduleFacadeMock->expects(static::atLeastOnce())
            ->method('createAndApplyPriceProductSchedule')
            ->with($this->priceProductScheduleTransferMock);

        $this->schedulePriceProductAbstractModel->update(
            $this->productAbstractTransferMock,
            $this->priceProductScheduleTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testGetPriceProductScheduleTransfer(): void
    {
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

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getIdCurrency')
            ->willReturn(1);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getIdStore')
            ->willReturn(1);

        $this->productApiSchedulePriceImportRepositoryMock->expects(static::atLeastOnce())
            ->method('findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore')
            ->with(1, 1, 1)
            ->willReturn($this->priceProductScheduleTransferMock);

        $this->schedulePriceProductAbstractModel->getPriceProductScheduleTransfer(1);
    }
}
