<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Communication\Plugin;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Product\Dependency\Plugin\ProductConcretePluginUpdateInterface;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportBusinessFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig getConfig()
 */
class SalePriceProductConcreteUpdatePlugin extends AbstractPlugin implements ProductConcretePluginUpdateInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function update(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        return $this->getFacade()->persistProductConcreteSalePrice($productConcreteTransfer);
    }
}
