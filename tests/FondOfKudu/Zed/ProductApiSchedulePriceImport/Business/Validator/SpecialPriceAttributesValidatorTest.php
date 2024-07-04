<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use PHPUnit\Framework\MockObject\MockObject;

class SpecialPriceAttributesValidatorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected MockObject|ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfigMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface
     */
    protected SpecialPriceAttributesValidatorInterface $validator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiSchedulePriceImportConfigMock = $this->createMock(ProductApiSchedulePriceImportConfig::class);
        $this->validator = new SpecialPriceAttributesValidator($this->apiSchedulePriceImportConfigMock);
    }

    /**
     * @return void
     */
    public function testValidateValid(): void
    {
        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        static::assertTrue($this->validator->validate([
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2060-12-31',
        ]));
    }

    /**
     * @return void
     */
    public function testValidateInvalidAttributeMissing(): void
    {
        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        static::assertFalse($this->validator->validate([
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => null,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2060-12-31',
        ]));
    }

    /**
     * @return void
     */
    public function testValidateInvalidSpecialPriceToIsInPast(): void
    {
        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        static::assertFalse($this->validator->validate([
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => '2999',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2020-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2023-12-31',
        ]));
    }
}
