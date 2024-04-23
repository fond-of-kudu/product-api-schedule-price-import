<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;

interface ProductApiSchedulePriceImportRepositoryInterface
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
    ): ?PriceProductScheduleTransfer;

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
    ): ?PriceProductScheduleTransfer;
}
