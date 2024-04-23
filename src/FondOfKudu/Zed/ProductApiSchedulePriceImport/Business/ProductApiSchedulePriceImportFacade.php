<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportBusinessFactory getFactory()
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface getRepository()
 */
class ProductApiSchedulePriceImportFacade extends AbstractFacade implements ProductApiSchedulePriceImportFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function onCreateProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        return $this->getFactory()
            ->createSalePriceHandler()
            ->handleProductAbstract($productAbstractTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function onUpdateProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        return $this->getFactory()
            ->createSalePriceHandler()
            ->handleProductAbstract($productAbstractTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function onCreateProductConcrete(
        ProductConcreteTransfer $productConcreteTransfer
    ): ProductConcreteTransfer {
        return $this->getFactory()
            ->createSalePriceHandler()
            ->handleProductConcrete($productConcreteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function onUpdateProductConcrete(
        ProductConcreteTransfer $productConcreteTransfer
    ): ProductConcreteTransfer {
        return $this->getFactory()
            ->createSalePriceHandler()
            ->handleProductConcrete($productConcreteTransfer);
    }
}
