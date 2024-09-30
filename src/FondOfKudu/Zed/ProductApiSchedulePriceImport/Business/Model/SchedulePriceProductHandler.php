<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class SchedulePriceProductHandler implements SchedulePriceProductHandlerInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface
     */
    protected SpecialPriceAttributesValidatorInterface $specialPriceAttributesValidator;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface
     */
    protected SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModelInterface
     */
    protected SchedulePriceProductConcreteModelInterface $schedulePriceProductConcreteModel;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModelInterface $schedulePriceProductConcreteModel
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface $specialPriceAttributesValidator
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(
        ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade,
        SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel,
        SchedulePriceProductConcreteModelInterface $schedulePriceProductConcreteModel,
        SpecialPriceAttributesValidatorInterface $specialPriceAttributesValidator,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
    ) {
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
        $this->specialPriceAttributesValidator = $specialPriceAttributesValidator;
        $this->schedulePriceProductAbstractModel = $schedulePriceProductAbstractModel;
        $this->schedulePriceProductConcreteModel = $schedulePriceProductConcreteModel;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handleProductAbstract(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        $productAttributes = $productAbstractTransfer->getAttributes();

        if (!$this->specialPriceAttributesValidator->hasRequiredProductAttributes($productAttributes)) {
            return $productAbstractTransfer;
        }

        $priceProductScheduleTransfer = $this->schedulePriceProductAbstractModel
            ->getPriceProductScheduleTransfer($productAbstractTransfer->getIdProductAbstract());

        if ($priceProductScheduleTransfer === null) {
            return $this->handleNewProductAbstract($productAbstractTransfer, $productAttributes);
        }

        return $this->handleExistingProductAbstract(
            $productAbstractTransfer,
            $productAttributes,
            $priceProductScheduleTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function handleProductConcrete(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        $productAttributes = $productConcreteTransfer->getAttributes();

        if (!$this->specialPriceAttributesValidator->hasRequiredProductAttributes($productAttributes)) {
            return $productConcreteTransfer;
        }

        $priceProductScheduleTransfer = $this->schedulePriceProductConcreteModel
            ->getPriceProductScheduleTransfer($productConcreteTransfer->getIdProductConcrete());

        if ($priceProductScheduleTransfer === null) {
            return $this->handleNewProductConcrete($productConcreteTransfer, $productAttributes);
        }

        return $this->handleExistingProductConcrete(
            $productConcreteTransfer,
            $productAttributes,
            $priceProductScheduleTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param array $productAttributes
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected function handleNewProductAbstract(ProductAbstractTransfer $productAbstractTransfer, array $productAttributes): ProductAbstractTransfer
    {
        if ($this->specialPriceAttributesValidator->validateProductAttributeValues($productAttributes)) {
            $this->schedulePriceProductAbstractModel->create($productAbstractTransfer);
        }

        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param array $productAttributes
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer|null $priceProductScheduleTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected function handleExistingProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer,
        array $productAttributes,
        ?PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): ProductAbstractTransfer {
        $hasDataChanged = $this->checkIfDataHasChangedAndDeleteSchedulePrice(
            $priceProductScheduleTransfer,
            $productAttributes,
        );

        if (
            $this->specialPriceAttributesValidator->validateProductAttributeValues($productAttributes) &&
            $hasDataChanged
        ) {
            $this->schedulePriceProductAbstractModel->update($productAbstractTransfer);
        }

        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param array $productAttributes
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected function handleNewProductConcrete(ProductConcreteTransfer $productConcreteTransfer, array $productAttributes): ProductConcreteTransfer
    {
        if ($this->specialPriceAttributesValidator->validateProductAttributeValues($productAttributes)) {
            $this->schedulePriceProductConcreteModel->create($productConcreteTransfer);
        }

        return $productConcreteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param array $productAttributes
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer|null $priceProductScheduleTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected function handleExistingProductConcrete(
        ProductConcreteTransfer $productConcreteTransfer,
        array $productAttributes,
        ?PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): ProductConcreteTransfer {
        $hasDataChanged = $this->checkIfDataHasChangedAndDeleteSchedulePrice(
            $priceProductScheduleTransfer,
            $productAttributes,
        );

        if (
            $this->specialPriceAttributesValidator->validateProductAttributeValues($productAttributes) &&
            $hasDataChanged
        ) {
            $this->schedulePriceProductConcreteModel->update($productConcreteTransfer, $priceProductScheduleTransfer);
        }

        return $productConcreteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer|null $priceProductScheduleTransfer
     * @param array $productAttributes
     *
     * @return bool
     */
    protected function checkIfDataHasChangedAndDeleteSchedulePrice(?PriceProductScheduleTransfer $priceProductScheduleTransfer, array $productAttributes): bool
    {
        if ($this->specialPriceAttributesValidator->hasSpecialPriceChanged($priceProductScheduleTransfer, $productAttributes)) {
            // Whenever the data has changed, even it is invalid to create a new one, the existing price must be deleted.
            $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
                $priceProductScheduleTransfer->getIdPriceProductSchedule(),
            );

            return true;
        }

        return false;
    }
}
