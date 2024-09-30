<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class SchedulePriceProductAbstractModel implements SchedulePriceProductAbstractModelInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected PriceProductScheduleMapperInterface $priceProductScheduleMapper;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface
     */
    protected ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface
     */
    protected ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface
     */
    protected ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface $priceProductScheduleMapper
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository
     */
    public function __construct(
        PriceProductScheduleMapperInterface $priceProductScheduleMapper,
        ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade,
        ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade,
        ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade,
        ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository
    ) {
        $this->priceProductScheduleMapper = $priceProductScheduleMapper;
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
        $this->currencyFacade = $currencyFacade;
        $this->storeFacade = $storeFacade;
        $this->productApiSchedulePriceImportRepository = $productApiSchedulePriceImportRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return void
     */
    public function create(ProductAbstractTransfer $productAbstractTransfer): void
    {
        $priceProductScheduleTransfer = $this->priceProductScheduleMapper
            ->createFromProductAbstractTransfer($productAbstractTransfer);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return void
     */
    public function update(ProductAbstractTransfer $productAbstractTransfer): void
    {
        $priceProductScheduleTransfer = $this->priceProductScheduleMapper
            ->createFromProductAbstractTransfer($productAbstractTransfer);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer|null
     */
    public function getPriceProductScheduleTransfer(int $idProductAbstract): ?PriceProductScheduleTransfer
    {
        $currencyTransfer = $this->currencyFacade->getCurrent();
        $currencyTransfer = $this->currencyFacade->findCurrencyByIsoCode($currencyTransfer->getCode());
        $storeTransfer = $this->storeFacade->getCurrentStore();

        return $this->productApiSchedulePriceImportRepository
            ->findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore(
                $idProductAbstract,
                $currencyTransfer->getIdCurrency(),
                $storeTransfer->getIdStore(),
            );
    }
}
