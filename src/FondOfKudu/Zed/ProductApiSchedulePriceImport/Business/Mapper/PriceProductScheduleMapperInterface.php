<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface PriceProductScheduleMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return array<\Generated\Shared\Transfer\PriceProductScheduleTransfer>
     */
    public function fromProductAbstractTransfer(ProductAbstractTransfer $productAbstractTransfer): array;
}
