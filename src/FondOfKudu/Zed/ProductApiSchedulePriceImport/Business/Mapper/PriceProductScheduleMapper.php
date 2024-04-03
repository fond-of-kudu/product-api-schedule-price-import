<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleListTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

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
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(
        ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
    ) {
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
        $this->priceProductFacade = $priceProductFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return array<\Generated\Shared\Transfer\PriceProductScheduleTransfer>
     */
    public function fromProductAbstractTransfer(ProductAbstractTransfer $productAbstractTransfer): array
    {
        $productAttributes = $productAbstractTransfer->getAttributes();
        $specialPriceFrom = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];
        $priceProductScheduleTransfers = [];

        $priceProductScheduleListTransfer = (new PriceProductScheduleListTransfer())
            ->setIdPriceProductScheduleList($this->apiSchedulePriceImportConfig->getIdPriceProductScheduleList());

        $priceProductScheduleTransfer = (new PriceProductScheduleTransfer())
            ->setPriceProductScheduleList($priceProductScheduleListTransfer)
            ->setActiveFrom($specialPriceFrom)
            ->setActiveTo($specialPriceTo);

        foreach ($productAbstractTransfer->getPrices() as $priceProductTransfer) {
            foreach ($productAbstractTransfer->getStoreRelation()->getStores() as $storeTransfer) {
                $priceTypeTransfer = $this->priceProductFacade->findPriceTypeByName(
                    $this->apiSchedulePriceImportConfig->getPriceDimensionRrp(),
                );

                $priceProductTransfer->getMoneyValue()->setGrossAmount($specialPrice);
                $priceProductScheduleTransfer
                    ->setStore($storeTransfer)
                    ->setPriceProduct($priceProductTransfer->setPriceType($priceTypeTransfer))
                    ->setCurrency($priceProductTransfer->getMoneyValue()->getCurrency());

                $priceProductScheduleTransfers[] = $priceProductScheduleTransfer;
            }
        }

        return $priceProductScheduleTransfers;
    }
}
