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
            ProductApiSchedulePriceImportConstants::PRICE_ORIGINAL,
        );
    }

    /**
     * @return string
     */
    public function getPriceDimensionSale(): string
    {
        return $this->get(
            ProductApiSchedulePriceImportConstants::PRICE_DIMENSION_SALE,
            ProductApiSchedulePriceImportConstants::PRICE_DEFAULT,
        );
    }
}
