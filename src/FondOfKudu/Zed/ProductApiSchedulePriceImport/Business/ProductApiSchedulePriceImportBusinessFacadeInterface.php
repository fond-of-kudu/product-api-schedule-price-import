<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

interface ProductApiSchedulePriceImportBusinessFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function persistProductAbstractSalePrice(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function persistProductConcreteSalePrice(
        ProductConcreteTransfer $productConcreteTransfer
    ): ProductConcreteTransfer;
}
