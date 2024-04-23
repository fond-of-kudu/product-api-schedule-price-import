<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportFacade;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductExtension\Dependency\Plugin\ProductAbstractPostCreatePluginInterface;

class SalePriceProductAbstractPostCreatePluginTest extends Unit
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
     * @var \Spryker\Zed\ProductExtension\Dependency\Plugin\ProductAbstractPostCreatePluginInterface
     */
    protected ProductAbstractPostCreatePluginInterface $salePriceProductAbstractPostCreatePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->apiSchedulePriceImportFacadeMock = $this->createMock(ProductApiSchedulePriceImportFacade::class);

        $this->salePriceProductAbstractPostCreatePlugin = new SalePriceProductAbstractPostCreatePlugin();
        $this->salePriceProductAbstractPostCreatePlugin->setFacade($this->apiSchedulePriceImportFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostCreate(): void
    {
        $this->apiSchedulePriceImportFacadeMock->expects(static::once())
            ->method('onCreateProductAbstract')
            ->willReturn($this->productAbstractTransferMock);

        $productAbstractTransfer = $this->salePriceProductAbstractPostCreatePlugin
            ->postCreate($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }
}
