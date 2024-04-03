<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractCreator;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractCreatorInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig getConfig()
 */
class ProductApiSchedulePriceImportBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractCreatorInterface
     */
    public function createSalePriceProductAbstractCreator(): SalePriceProductAbstractCreatorInterface
    {
        return new SalePriceProductAbstractCreator(
            $this->getPriceProductScheduleFacade(),
            $this->createPriceProductScheduleMapper(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected function createPriceProductScheduleMapper(): PriceProductScheduleMapperInterface
    {
        return new PriceProductScheduleMapper(
            $this->getPriceProductFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected function getPriceProductScheduleFacade(): ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
    {
        return $this->getProvidedDependency(ProductApiSchedulePriceImportDependencyProvider::FACADE_PRICE_PRODUCT_SCHEDULE);
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface
     */
    protected function getPriceProductFacade(): ProductApiSchedulePriceImportToPriceProductFacadeInterface
    {
        return $this->getProvidedDependency(ProductApiSchedulePriceImportDependencyProvider::FACADE_PRICE_PRODUCT);
    }
}
