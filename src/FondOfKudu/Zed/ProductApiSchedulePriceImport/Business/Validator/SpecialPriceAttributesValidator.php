<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator;

use DateTime;
use Exception;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;

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
        if (!$this->validateSpecialPriceAttributes($productAttributes)) {
            return false;
        }

        return $this->isSpecialPriceToInFuture($productAttributes[$this->config->getProductAttributeSalePriceTo()]);
    }

    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    protected function validateSpecialPriceAttributes(array $productAttributes): bool
    {
        $required = [
            $this->config->getProductAttributeSalePrice(),
            $this->config->getProductAttributeSalePriceFrom(),
            $this->config->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $attribute) {
            if (!isset($productAttributes[$attribute])) {
                return false;
            }

            if (!$productAttributes[$attribute]) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $specialPriceTo
     *
     * @return bool
     */
    protected function isSpecialPriceToInFuture(string $specialPriceTo): bool
    {
        try {
            $specialPriceTo = new DateTime($specialPriceTo);
        } catch (Exception $exception) {
            return false;
        }

        return $specialPriceTo >= new DateTime();
    }
}
