<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceHandler;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceHandlerInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig getConfig()
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface getRepository()
 */
class ProductApiSchedulePriceImportBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceHandlerInterface
     */
    public function createSalePriceHandler(): SalePriceHandlerInterface
    {
        return new SalePriceHandler(
            $this->createPriceProductScheduleMapper(),
            $this->getPriceProductScheduleFacade(),
            $this->getCurrencyFacade(),
            $this->getStoreFacade(),
            $this->getRepository(),
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
            $this->getCurrencyFacade(),
            $this->getStoreFacade(),
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

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface
     */
    protected function getCurrencyFacade(): ProductApiSchedulePriceImportToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(ProductApiSchedulePriceImportDependencyProvider::FACADE_CURRENCY);
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface
     */
    protected function getStoreFacade(): ProductApiSchedulePriceImportToStoreFacadeInterface
    {
        return $this->getProvidedDependency(ProductApiSchedulePriceImportDependencyProvider::FACADE_STORE);
    }
}
