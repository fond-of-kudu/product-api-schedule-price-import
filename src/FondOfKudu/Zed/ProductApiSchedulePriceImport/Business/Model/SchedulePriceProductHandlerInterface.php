<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

interface SchedulePriceProductHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handleProductAbstract(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function handleProductConcrete(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer;
}
