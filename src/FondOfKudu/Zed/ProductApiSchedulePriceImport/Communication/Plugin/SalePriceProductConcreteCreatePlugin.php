<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Communication\Plugin;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductExtension\Dependency\Plugin\ProductConcreteCreatePluginInterface;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportBusinessFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig getConfig()
 */
class SalePriceProductConcreteCreatePlugin extends AbstractPlugin implements ProductConcreteCreatePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function create(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        return $this->getFacade()->persistProductConcreteSalePrice($productConcreteTransfer);
    }
}
