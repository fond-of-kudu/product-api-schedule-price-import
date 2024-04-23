<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use DateTime;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class SalePriceHandler implements SalePriceHandlerInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface
     */
    protected ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface
     */
    protected ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface
     */
    protected ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected PriceProductScheduleMapperInterface $priceProductScheduleMapper;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface $priceProductScheduleMapper
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(
        PriceProductScheduleMapperInterface $priceProductScheduleMapper,
        ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade,
        ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade,
        ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade,
        ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
    ) {
        $this->priceProductScheduleMapper = $priceProductScheduleMapper;
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
        $this->currencyFacade = $currencyFacade;
        $this->storeFacade = $storeFacade;
        $this->productApiSchedulePriceImportRepository = $productApiSchedulePriceImportRepository;
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handleProductAbstract(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        if (!$this->validateSpecialPriceAttributes($productAbstractTransfer->getAttributes())) {
            return $productAbstractTransfer;
        }

        $currencyTransfer = $this->currencyFacade->getCurrent();
        $currencyTransfer = $this->currencyFacade->findCurrencyByIsoCode($currencyTransfer->getCode());
        $storeTransfer = $this->storeFacade->getCurrentStore();

        $priceProductScheduleTransfer = $this->productApiSchedulePriceImportRepository
            ->findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore(
                $productAbstractTransfer->getIdProductAbstract(),
                $currencyTransfer->getIdCurrency(),
                $storeTransfer->getIdStore(),
            );

        if ($priceProductScheduleTransfer !== null && $this->hasDataChanged($priceProductScheduleTransfer, $productAbstractTransfer->getAttributes())) {
            $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
                $priceProductScheduleTransfer->getIdPriceProductSchedule(),
            );
        }

        $priceProductScheduleTransfer = $this->priceProductScheduleMapper
            ->createFromProductAbstractTransfer($productAbstractTransfer);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);

        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function handleProductConcrete(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        if (!$this->validateSpecialPriceAttributes($productConcreteTransfer->getAttributes())) {
            return $productConcreteTransfer;
        }

        $currencyTransfer = $this->currencyFacade->getCurrent();
        $currencyTransfer = $this->currencyFacade->findCurrencyByIsoCode($currencyTransfer->getCode());
        $storeTransfer = $this->storeFacade->getCurrentStore();

        $priceProductScheduleTransfer = $this->productApiSchedulePriceImportRepository
            ->findPriceProductScheduleByIdProductConcreteAndIdCurrencyAndIdStore(
                $productConcreteTransfer->getIdProductConcrete(),
                $currencyTransfer->getIdCurrency(),
                $storeTransfer->getIdStore(),
            );

        if (
            $priceProductScheduleTransfer !== null
            && $this->hasDataChanged($priceProductScheduleTransfer, $productConcreteTransfer->getAttributes())
        ) {
            $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
                $priceProductScheduleTransfer->getIdPriceProductSchedule(),
            );
        }

        $priceProductScheduleTransfer = $this->priceProductScheduleMapper
            ->createFromProductConcreteTransfer($productConcreteTransfer);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);

        return $productConcreteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     * @param array $productAttributes
     *
     * @return bool
     */
    protected function hasDataChanged(
        PriceProductScheduleTransfer $priceProductScheduleTransfer,
        array $productAttributes
    ): bool {
        $specialPriceFrom = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];

        $specialPriceFrom = new DateTime($specialPriceFrom);
        $specialPriceTo = new DateTime($specialPriceTo);

        $priceProductScheduleActiveFrom = new DateTime($priceProductScheduleTransfer->getActiveFrom());
        $priceProductScheduleActiveTo = new DateTime($priceProductScheduleTransfer->getActiveTo());
        $priceProductScheduleGrossAmount = $priceProductScheduleTransfer->getPriceProduct()->getMoneyValue()->getGrossAmount();

        if ($specialPriceFrom->format('Y-m-d') !== $priceProductScheduleActiveFrom->format('Y-m-d')) {
            return true;
        }

        if ($specialPriceTo->format('Y-m-d') !== $priceProductScheduleActiveTo->format('Y-m-d')) {
            return true;
        }

        if ((int)$specialPrice !== $priceProductScheduleGrossAmount) {
            return true;
        }

        return false;
    }

    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    protected function validateSpecialPriceAttributes(array $productAttributes): bool
    {
        $required = [
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePrice(),
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom(),
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $attribute) {
            if (!isset($productAttributes[$attribute])) {
                return false;
            }

            if (!$productAttributes[$attribute]) {
                return false;
            }
        }

        return true;
    }
}
