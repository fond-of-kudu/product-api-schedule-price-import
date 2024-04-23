<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade;

use Generated\Shared\Transfer\PriceProductScheduleResponseTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Spryker\Zed\PriceProductSchedule\Business\PriceProductScheduleFacadeInterface;

class ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge implements ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
{
    /**
     * @var \Spryker\Zed\PriceProductSchedule\Business\PriceProductScheduleFacadeInterface
     */
    protected PriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @param \Spryker\Zed\PriceProductSchedule\Business\PriceProductScheduleFacadeInterface $priceProductScheduleFacade
     */
    public function __construct(PriceProductScheduleFacadeInterface $priceProductScheduleFacade)
    {
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleResponseTransfer
     */
    public function createAndApplyPriceProductSchedule(
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): PriceProductScheduleResponseTransfer {
        return $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleResponseTransfer
     */
    public function updateAndApplyPriceProductSchedule(
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): PriceProductScheduleResponseTransfer {
        return $this->priceProductScheduleFacade->updateAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param int $idPriceProductSchedule
     *
     * @return void
     */
    public function removeAndApplyPriceProductSchedule(int $idPriceProductSchedule): void
    {
        $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule($idPriceProductSchedule);
    }
}
