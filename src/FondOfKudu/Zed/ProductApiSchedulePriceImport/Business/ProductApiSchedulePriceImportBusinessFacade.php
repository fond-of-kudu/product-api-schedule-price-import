<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportBusinessFactory getFactory()
 */
class ProductApiSchedulePriceImportBusinessFacade extends AbstractFacade implements ProductApiSchedulePriceImportBusinessFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function persistProductAbstractSalePrice(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function persistProductConcreteSalePrice(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        return $productConcreteTransfer;
    }
}
