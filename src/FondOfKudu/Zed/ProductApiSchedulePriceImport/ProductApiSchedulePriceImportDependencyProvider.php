<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig getConfig()
 */
class ProductApiSchedulePriceImportDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PRICE_PRODUCT_SCHEDULE = 'FACADE_PRICE_PRODUCT_SCHEDULE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        return parent::provideBusinessLayerDependencies($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        return parent::provideCommunicationLayerDependencies($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        return parent::providePersistenceLayerDependencies($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductScheduleFacade(Container $container): Container
    {
        $container[static::FACADE_PRICE_PRODUCT_SCHEDULE] = static fn (
            Container $container
        ): ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface => new ProductApiSchedulePriceImportToPriceProductScheduleFacadeBridge(
            $container->getLocator()->priceProductSchedule()->facade(),
        );

        return $container;
    }
}
