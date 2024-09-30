<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator;

use Codeception\Test\Unit;
use FondOfKudu\Shared\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConstants;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SpecialPriceAttributesValidatorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected MockObject|ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    protected MockObject|PriceProductScheduleTransfer $priceProductScheduleTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceProductTransfer
     */
    protected MockObject|PriceProductTransfer $priceProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected MockObject|MoneyValueTransfer $moneyValueTransferMock;

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
        $this->priceProductScheduleTransferMock = $this->createMock(PriceProductScheduleTransfer::class);
        $this->priceProductTransferMock = $this->createMock(PriceProductTransfer::class);
        $this->moneyValueTransferMock = $this->createMock(MoneyValueTransfer::class);
        $this->validator = new SpecialPriceAttributesValidator($this->apiSchedulePriceImportConfigMock);
    }

    /**
     * @return void
     */
    public function testValidateSuccess(): void
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

        $productAttributes = [
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2026-12-31',
        ];

        static::assertTrue($this->validator->validate($productAttributes));
    }

    /**
     * @return void
     */
    public function testValidateFailedRequiredAttributeMissing(): void
    {
        $productAttributes = [
            // ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2024-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2024-12-31',
        ];

        static::assertFalse($this->validator->validate($productAttributes));
    }

    /**
     * @return void
     */
    public function testValidateFailedSpecialPriceToInPast(): void
    {
        $productAttributes = [
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2023-12-31',
        ];

        static::assertFalse($this->validator->validate($productAttributes));
    }

    /**
     * @return void
     */
    public function testHasSpecialPriceChangedNoDataChanged(): void
    {
        $productAttributes = [
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2026-12-31',
        ];

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveFrom')
            ->willReturn($productAttributes[ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM]);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveTo')
            ->willReturn($productAttributes[ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO]);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getPriceProduct')
            ->willReturn($this->priceProductTransferMock);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn($productAttributes[ProductApiSchedulePriceImportConstants::SPECIAL_PRICE]);

        $result = $this->validator->hasSpecialPriceChanged($this->priceProductScheduleTransferMock, $productAttributes);

        static::assertFalse($result);
    }

    /**
     * @return void
     */
    public function testHasSpecialPriceChanged(): void
    {
        $productAttributes = [
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2026-12-31',
        ];

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveFrom')
            ->willReturn($productAttributes[ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM]);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getActiveTo')
            ->willReturn($productAttributes[ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO]);

        $this->priceProductScheduleTransferMock->expects(static::atLeastOnce())
            ->method('getPriceProduct')
            ->willReturn($this->priceProductTransferMock);

        $this->priceProductTransferMock->expects(static::atLeastOnce())
            ->method('getMoneyValue')
            ->willReturn($this->moneyValueTransferMock);

        $this->moneyValueTransferMock->expects(static::atLeastOnce())
            ->method('getGrossAmount')
            ->willReturn(4999);

        $result = $this->validator->hasSpecialPriceChanged($this->priceProductScheduleTransferMock, $productAttributes);

        static::assertTrue($result);
    }

    /**
     * @return void
     */
    public function testHasRequiredProductAttributesSuccess(): void
    {
        $productAttributes = [
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2026-12-31',
        ];

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        static::assertTrue($this->validator->hasRequiredProductAttributes($productAttributes));
    }

    /**
     * @return void
     */
    public function testHasRequiredProductAttributesFailed(): void
    {
        $productAttributes = [
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            //ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2026-12-31',
        ];

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        static::assertFalse($this->validator->hasRequiredProductAttributes($productAttributes));
    }

    /**
     * @return void
     */
    public function testValidateProductAttributeValuesSuccess(): void
    {
        $productAttributes = [
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => '2023-01-01',
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2026-12-31',
        ];

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        static::assertTrue($this->validator->validateProductAttributeValues($productAttributes));
    }

    /**
     * @return void
     */
    public function testValidateProductAttributeValuesFailed(): void
    {
        $productAttributes = [
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE => 5999,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM => null,
            ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO => '2026-12-31',
        ];

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePrice')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceFrom')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_FROM);

        $this->apiSchedulePriceImportConfigMock->expects(static::atLeastOnce())
            ->method('getProductAttributeSalePriceTo')
            ->willReturn(ProductApiSchedulePriceImportConstants::SPECIAL_PRICE_TO);

        static::assertFalse($this->validator->validateProductAttributeValues($productAttributes));
    }
}
