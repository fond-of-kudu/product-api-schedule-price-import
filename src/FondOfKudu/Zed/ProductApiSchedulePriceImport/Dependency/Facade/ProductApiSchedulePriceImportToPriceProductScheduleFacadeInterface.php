<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade;

use Generated\Shared\Transfer\PriceProductScheduleResponseTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;

interface ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleResponseTransfer
     */
    public function createAndApplyPriceProductSchedule(
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): PriceProductScheduleResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleResponseTransfer
     */
    public function updateAndApplyPriceProductSchedule(
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): PriceProductScheduleResponseTransfer;

    /**
     * @param int $idPriceProductSchedule
     *
     * @return void
     */
    public function removeAndApplyPriceProductSchedule(int $idPriceProductSchedule): void;
}
