<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use DateTime;
use Exception;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface;
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
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModelInterface $schedulePriceProductConcreteModel
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface $specialPriceAttributesValidator
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(
        SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel,
        SchedulePriceProductConcreteModelInterface $schedulePriceProductConcreteModel,
        SpecialPriceAttributesValidatorInterface $specialPriceAttributesValidator,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
    ) {
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
        if (!$this->specialPriceAttributesValidator->validate($productAbstractTransfer->getAttributes())) {
            return $productAbstractTransfer;
        }

        $priceProductScheduleTransfer = $this->schedulePriceProductAbstractModel
            ->getPriceProductScheduleTransfer($productAbstractTransfer->getIdProductAbstract());

        if ($priceProductScheduleTransfer === null) {
            $this->schedulePriceProductAbstractModel->create($productAbstractTransfer);

            return $productAbstractTransfer;
        }

        if ($this->hasDataChanged($priceProductScheduleTransfer, $productAbstractTransfer->getAttributes())) {
            $this->schedulePriceProductAbstractModel->update($productAbstractTransfer, $priceProductScheduleTransfer);
        }

        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function handleProductConcrete(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        if (!$this->specialPriceAttributesValidator->validate($productConcreteTransfer->getAttributes())) {
            return $productConcreteTransfer;
        }

        $priceProductScheduleTransfer = $this->schedulePriceProductConcreteModel
            ->getPriceProductScheduleTransfer($productConcreteTransfer->getIdProductConcrete());

        if ($priceProductScheduleTransfer === null) {
            $this->schedulePriceProductConcreteModel->create($productConcreteTransfer);

            return $productConcreteTransfer;
        }

        if ($this->hasDataChanged($priceProductScheduleTransfer, $productConcreteTransfer->getAttributes())) {
            $this->schedulePriceProductConcreteModel->update($productConcreteTransfer, $priceProductScheduleTransfer);
        }

        return $productConcreteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     * @param array $productAttributes
     *
     * @return bool
     */
    protected function hasDataChanged(PriceProductScheduleTransfer $priceProductScheduleTransfer, array $productAttributes): bool
    {
        try {
            $specialPriceFrom = new DateTime($productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()]);
            $specialPriceTo = new DateTime($productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()]);
            $priceProductScheduleActiveFrom = new DateTime($priceProductScheduleTransfer->getActiveFrom());
            $priceProductScheduleActiveTo = new DateTime($priceProductScheduleTransfer->getActiveTo());
        } catch (Exception $e) {
            return false;
        }

        $specialPrice = (int)$productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];
        $priceProductScheduleGrossAmount = $priceProductScheduleTransfer->getPriceProduct()->getMoneyValue()->getGrossAmount();

        return $specialPriceFrom->getTimestamp() !== $priceProductScheduleActiveFrom->getTimestamp()
            || $specialPriceTo->getTimestamp() !== $priceProductScheduleActiveTo->getTimestamp()
            || $specialPrice !== $priceProductScheduleGrossAmount;
    }
}
