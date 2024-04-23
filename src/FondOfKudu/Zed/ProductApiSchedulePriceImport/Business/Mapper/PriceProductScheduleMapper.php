<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class PriceProductScheduleMapper implements PriceProductScheduleMapperInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface
     */
    protected ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface
     */
    protected ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade
     */
    public function __construct(
        ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig,
        ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade,
        ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade
    ) {
        $this->priceProductFacade = $priceProductFacade;
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
        $this->currencyFacade = $currencyFacade;
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function createFromProductAbstractTransfer(
        ProductAbstractTransfer $productAbstractTransfer
    ): PriceProductScheduleTransfer {
        $priceProductTransfer = (new PriceProductTransfer())
            ->setIdProductAbstract($productAbstractTransfer->getIdProductAbstract());

        return $this->create($priceProductTransfer, $productAbstractTransfer->getAttributes());
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function createFromProductConcreteTransfer(
        ProductConcreteTransfer $productConcreteTransfer
    ): PriceProductScheduleTransfer {
        $priceProductTransfer = (new PriceProductTransfer())
            ->setIdProduct($productConcreteTransfer->getIdProductConcrete());

        return $this->create($priceProductTransfer, $productConcreteTransfer->getAttributes());
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param array $productAttributes
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    protected function create(
        PriceProductTransfer $priceProductTransfer,
        array $productAttributes
    ): PriceProductScheduleTransfer {
        $currencyTransfer = $this->currencyFacade->getCurrent();
        $currencyTransfer = $this->currencyFacade->findCurrencyByIsoCode($currencyTransfer->getCode());
        $storeTransfer = $this->storeFacade->getCurrentStore();

        $specialPriceFrom = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];

        $priceTypeTransfer = $this->priceProductFacade->findPriceTypeByName(
            $this->apiSchedulePriceImportConfig->getPriceDimensionRrp(),
        );

        $moneyValueTransfer = (new MoneyValueTransfer())
            ->setFkStore($storeTransfer->getIdStore())
            ->setFkCurrency($currencyTransfer->getIdCurrency())
            ->setCurrency($currencyTransfer)
            ->setGrossAmount($specialPrice)
            ->setStore($storeTransfer);

        $priceProductTransfer->setMoneyValue($moneyValueTransfer)
            ->setPriceType($priceTypeTransfer);

        return (new PriceProductScheduleTransfer())
            ->setPriceProduct($priceProductTransfer)
            ->setActiveFrom($specialPriceFrom)
            ->setActiveTo($specialPriceTo);
    }
}
