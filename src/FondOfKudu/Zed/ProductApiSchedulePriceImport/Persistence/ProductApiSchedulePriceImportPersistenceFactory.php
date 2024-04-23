<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Finder\PriceProductScheduleFinder;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Finder\PriceProductScheduleFinderInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleListMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleListMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleMapper;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportDependencyProvider;
use Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductScheduleQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig getConfig()
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface getRepository()
 */
class ProductApiSchedulePriceImportPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Finder\PriceProductScheduleFinderInterface
     */
    public function createPriceProductScheduleFinder(): PriceProductScheduleFinderInterface
    {
        return new PriceProductScheduleFinder(
            $this->getPriceProductScheduleQuery(),
            $this->createPriceProductScheduleMapper(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleListMapperInterface
     */
    protected function createPriceProductScheduleListMapper(): PriceProductScheduleListMapperInterface
    {
        return new PriceProductScheduleListMapper();
    }

    /**
     * @return \Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductScheduleQuery
     */
    protected function getPriceProductScheduleQuery(): SpyPriceProductScheduleQuery
    {
        return $this->getProvidedDependency(ProductApiSchedulePriceImportDependencyProvider::QUERY_PRICE_PRODUCT_SCHEDULE);
    }

    /**
     * @return \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleMapperInterface
     */
    protected function createPriceProductScheduleMapper(): PriceProductScheduleMapperInterface
    {
        return new PriceProductScheduleMapper($this->createPriceProductScheduleListMapper());
    }
}
