<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

interface SchedulePriceProductConcreteModelInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    public function create(ProductConcreteTransfer $productConcreteTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return void
     */
    public function update(
        ProductConcreteTransfer $productConcreteTransfer,
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): void;

    /**
     * @param int $idProductConcrete
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer|null
     */
    public function getPriceProductScheduleTransfer(int $idProductConcrete): ?PriceProductScheduleTransfer;
}
