<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModel;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModel;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModelInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductHandler;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductHandlerInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidator;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface;
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
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductHandlerInterface
     */
    public function createSchedulePriceProductHandler(): SchedulePriceProductHandlerInterface
    {
        return new SchedulePriceProductHandler(
            $this->getPriceProductScheduleFacade(),
            $this->createSchedulePriceProductAbstractModel(),
            $this->createSchedulePriceProductConcreteModel(),
            $this->createSpecialPriceAttributesValidator(),
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
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface
     */
    protected function createSpecialPriceAttributesValidator(): SpecialPriceAttributesValidatorInterface
    {
        return new SpecialPriceAttributesValidator($this->getConfig());
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface
     */
    protected function createSchedulePriceProductAbstractModel(): SchedulePriceProductAbstractModelInterface
    {
        return new SchedulePriceProductAbstractModel(
            $this->createPriceProductScheduleMapper(),
            $this->getPriceProductScheduleFacade(),
            $this->getCurrencyFacade(),
            $this->getStoreFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModelInterface
     */
    protected function createSchedulePriceProductConcreteModel(): SchedulePriceProductConcreteModelInterface
    {
        return new SchedulePriceProductConcreteModel(
            $this->createPriceProductScheduleMapper(),
            $this->getPriceProductScheduleFacade(),
            $this->getCurrencyFacade(),
            $this->getStoreFacade(),
            $this->getRepository(),
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
