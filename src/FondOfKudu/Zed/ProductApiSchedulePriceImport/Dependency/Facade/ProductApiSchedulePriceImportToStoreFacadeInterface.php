<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface ProductApiSchedulePriceImportToStoreFacadeInterface
{
    /**
     * @param bool $fallbackToDefault
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(bool $fallbackToDefault = false): StoreTransfer;
}
