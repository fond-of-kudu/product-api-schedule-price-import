<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface SalePriceProductAbstractCreatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function createProductSchedulePriceByProductAbstractTransfer(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer;
}
