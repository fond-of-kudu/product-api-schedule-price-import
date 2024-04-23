<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportPersistenceFactory getFactory()
 */
class ProductApiSchedulePriceImportRepository extends AbstractRepository implements ProductApiSchedulePriceImportRepositoryInterface
{
    /**
     * @param int $idProductAbstract
     * @param int $idCurrency
     * @param int $idStore
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer|null
     */
    public function findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore(
        int $idProductAbstract,
        int $idCurrency,
        int $idStore
    ): ?PriceProductScheduleTransfer {
        return $this->getFactory()
            ->createPriceProductScheduleFinder()
            ->findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore(
                $idProductAbstract,
                $idCurrency,
                $idStore,
            );
    }

    /**
     * @param int $idProductConcrete
     * @param int $idCurrency
     * @param int $idStore
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer|null
     */
    public function findPriceProductScheduleByIdProductConcreteAndIdCurrencyAndIdStore(
        int $idProductConcrete,
        int $idCurrency,
        int $idStore
    ): ?PriceProductScheduleTransfer {
        return $this->getFactory()
            ->createPriceProductScheduleFinder()
            ->findPriceProductScheduleByIdProductConcreteAndIdCurrencyAndIdStore(
                $idProductConcrete,
                $idCurrency,
                $idStore,
            );
    }
}
