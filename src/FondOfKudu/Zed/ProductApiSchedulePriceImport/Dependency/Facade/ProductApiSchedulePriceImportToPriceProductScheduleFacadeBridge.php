<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade;

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
}
