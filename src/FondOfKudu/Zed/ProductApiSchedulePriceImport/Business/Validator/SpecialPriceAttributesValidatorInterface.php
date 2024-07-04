<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator;

interface SpecialPriceAttributesValidatorInterface
{
    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    public function validate(array $productAttributes): bool;
}
