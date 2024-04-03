<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade;

use Generated\Shared\Transfer\PriceTypeTransfer;
use Spryker\Zed\PriceProduct\Business\PriceProductFacadeInterface;

class ProductApiSchedulePriceImportToPriceProductFacadeBridge implements ProductApiSchedulePriceImportToPriceProductFacadeInterface
{
    /**
     * @var \Spryker\Zed\PriceProduct\Business\PriceProductFacadeInterface
     */
    protected PriceProductFacadeInterface $priceProductFacade;

    /**
     * @param \Spryker\Zed\PriceProduct\Business\PriceProductFacadeInterface $priceProductFacade
     */
    public function __construct(PriceProductFacadeInterface $priceProductFacade)
    {
        $this->priceProductFacade = $priceProductFacade;
    }

    /**
     * @param string $priceTypeName
     *
     * @return \Generated\Shared\Transfer\PriceTypeTransfer|null
     */
    public function findPriceTypeByName(string $priceTypeName): ?PriceTypeTransfer
    {
        return $this->priceProductFacade->findPriceTypeByName($priceTypeName);
    }
}
