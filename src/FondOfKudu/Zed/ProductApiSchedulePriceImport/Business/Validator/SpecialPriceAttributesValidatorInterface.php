<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;

interface SpecialPriceAttributesValidatorInterface
{
    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    public function validate(array $productAttributes): bool;

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     * @param array $productAttributes
     *
     * @return bool
     */
    public function hasSpecialPriceChanged(
        PriceProductScheduleTransfer $priceProductScheduleTransfer,
        array $productAttributes
    ): bool;

    /**
     * @param string $specialPriceTo
     *
     * @return bool
     */
    public function isSpecialPriceToInFuture(string $specialPriceTo): bool;

    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    public function hasRequiredProductAttributes(array $productAttributes): bool;

    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    public function validateProductAttributeValues(array $productAttributes): bool;
}
