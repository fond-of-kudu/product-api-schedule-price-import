<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

interface SchedulePriceProductAbstractModelInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return void
     */
    public function create(ProductAbstractTransfer $productAbstractTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return void
     */
    public function update(
        ProductAbstractTransfer $productAbstractTransfer,
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): void;

    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer|null
     */
    public function getPriceProductScheduleTransfer(int $idProductAbstract): ?PriceProductScheduleTransfer;
}
