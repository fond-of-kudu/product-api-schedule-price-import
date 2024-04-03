<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport;

use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ProductApiSchedulePriceImportConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getPriceDimensionRrp(): string
    {
        return $this->get(
            ProductApiSchedulePriceImportConstants::PRICE_DIMENSION_RRP,
            ProductApiSchedulePriceImportConstants::PRICE_DEFAULT,
        );
    }

    /**
     * @return string
     */
    public function getPriceDimensionSale(): string
    {
        return $this->get(
            ProductApiSchedulePriceImportConstants::PRICE_DIMENSION_SALE,
            ProductApiSchedulePriceImportConstants::PRICE_ORIGINAL,
        );
    }

    /**
     * @return string
     */
    public function getProductAttributeSalePrice(): string
    {
        return $this->get(
            ProductApiSchedulePriceImportConstants::PRODUCT_ATTR_SPECIAL_PRICE,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE,
        );
    }

    /**
     * @return string
     */
    public function getProductAttributeSalePriceFrom(): string
    {
        return $this->get(
            ProductApiSchedulePriceImportConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM,
        );
    }

    /**
     * @return string
     */
    public function getProductAttributeSalePriceTo(): string
    {
        return $this->get(
            ProductApiSchedulePriceImportConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO,
        );
    }

    /**
     * @return int
     */
    public function getIdPriceProductScheduleList(): int
    {
        return $this->get(
            ProductApiSchedulePriceImportConstants::ID_PRICE_PRODUCT_SCHEDULE_LIST,
            ProductApiSchedulePriceImportConstants::ID_PRICE_PRODUCT_SCHEDULE_LIST_DEFAULT_VALUE,
        );
    }
}
