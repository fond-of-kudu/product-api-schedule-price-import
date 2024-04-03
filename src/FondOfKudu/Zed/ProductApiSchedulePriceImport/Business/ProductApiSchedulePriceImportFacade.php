<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportBusinessFactory getFactory()
 */
class ProductApiSchedulePriceImportFacade extends AbstractFacade implements ProductApiSchedulePriceImportFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function createPriceProductAbstractSchedule(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        return $this->getFactory()
            ->createSalePriceProductAbstractCreator()
            ->createProductSchedulePriceByProductAbstractTransfer($productAbstractTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function updatePriceProductAbstractSchedule(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function createPriceProductConcreteSchedule(
        ProductConcreteTransfer $productConcreteTransfer
    ): ProductConcreteTransfer {
        return $productConcreteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function updatePriceProductConcreteSchedule(
        ProductConcreteTransfer $productConcreteTransfer
    ): ProductConcreteTransfer {
        return $productConcreteTransfer;
    }
}
