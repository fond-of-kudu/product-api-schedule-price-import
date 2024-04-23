<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;

interface ProductApiSchedulePriceImportToCurrencyFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrent(): CurrencyTransfer;

    /**
     * @param string $isoCode
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer|null
     */
    public function findCurrencyByIsoCode(string $isoCode): ?CurrencyTransfer;
}
