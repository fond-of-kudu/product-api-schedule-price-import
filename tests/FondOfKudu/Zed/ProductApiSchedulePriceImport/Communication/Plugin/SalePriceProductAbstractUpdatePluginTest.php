<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportFacade;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Product\Dependency\Plugin\ProductAbstractPluginUpdateInterface;

class SalePriceProductAbstractUpdatePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportFacade
     */
    protected MockObject|ProductApiSchedulePriceImportFacade $apiSchedulePriceImportFacadeMock;

    /**
     * @var \Spryker\Zed\Product\Dependency\Plugin\ProductAbstractPluginUpdateInterface
     */
    protected ProductAbstractPluginUpdateInterface $salePriceProductAbstractPostCreatePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->apiSchedulePriceImportFacadeMock = $this->createMock(ProductApiSchedulePriceImportFacade::class);

        $this->salePriceProductAbstractPostCreatePlugin = new SalePriceProductAbstractUpdatePlugin();
        $this->salePriceProductAbstractPostCreatePlugin->setFacade($this->apiSchedulePriceImportFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostCreate(): void
    {
        $this->apiSchedulePriceImportFacadeMock->expects(static::once())
            ->method('onUpdateProductAbstract')
            ->willReturn($this->productAbstractTransferMock);

        $productAbstractTransfer = $this->salePriceProductAbstractPostCreatePlugin
            ->update($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }
}
