<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator;

use DateTime;
use Exception;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;

class SpecialPriceAttributesValidator implements SpecialPriceAttributesValidatorInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $config;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig)
    {
        $this->config = $apiSchedulePriceImportConfig;
    }

    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    public function validate(array $productAttributes): bool
    {
        if (!$this->hasRequiredProductAttributes($productAttributes)) {
            return false;
        }

        return $this->isSpecialPriceToInFuture($productAttributes[$this->config->getProductAttributeSalePriceTo()]);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer|null $priceProductScheduleTransfer
     * @param array $productAttributes
     *
     * @return bool
     */
    public function hasSpecialPriceChanged(
        ?PriceProductScheduleTransfer $priceProductScheduleTransfer,
        array $productAttributes
    ): bool {
        if ($priceProductScheduleTransfer === null) {
            return false;
        }

        if ($this->hasRequiredProductAttributes($productAttributes) === false) {
            return false;
        }

        $currentSpecialPriceFrom = new DateTime($priceProductScheduleTransfer->getActiveFrom());
        $currentSpecialPriceTo = new DateTime($priceProductScheduleTransfer->getActiveTo());
        $currentSpecialPrice = $priceProductScheduleTransfer->getPriceProduct()->getMoneyValue()->getGrossAmount();
        $specialPrice = (int)$productAttributes[$this->config->getProductAttributeSalePrice()];

        try {
            $specialPriceFrom = new DateTime($productAttributes[$this->config->getProductAttributeSalePriceFrom()]);
            $specialPriceTo = new DateTime($productAttributes[$this->config->getProductAttributeSalePriceTo()]);
        } catch (Exception $e) {
            $specialPriceFrom = null;
            $specialPriceTo = null;
        }

        return $specialPriceFrom->getTimestamp() !== $currentSpecialPriceFrom->getTimestamp()
            || $specialPriceTo->getTimestamp() !== $currentSpecialPriceTo->getTimestamp()
            || $specialPrice !== $currentSpecialPrice;
    }

    /**
     * @param string $specialPriceTo
     *
     * @return bool
     */
    public function isSpecialPriceToInFuture(string $specialPriceTo): bool
    {
        try {
            $specialPriceTo = new DateTime($specialPriceTo);
        } catch (Exception $exception) {
            return false;
        }

        return $specialPriceTo >= new DateTime();
    }

    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    public function hasRequiredProductAttributes(array $productAttributes): bool
    {
        $required = [
            $this->config->getProductAttributeSalePrice(),
            $this->config->getProductAttributeSalePriceFrom(),
            $this->config->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $attribute) {
            if (!array_key_exists($attribute, $productAttributes)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    public function validateProductAttributeValues(array $productAttributes): bool
    {
        if ($this->hasRequiredProductAttributes($productAttributes) === false) {
            return false;
        }

        $required = [
            $this->config->getProductAttributeSalePrice(),
            $this->config->getProductAttributeSalePriceFrom(),
            $this->config->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $attribute) {
            if (!isset($productAttributes[$attribute])) {
                return false;
            }
        }

        return true;
    }
}
