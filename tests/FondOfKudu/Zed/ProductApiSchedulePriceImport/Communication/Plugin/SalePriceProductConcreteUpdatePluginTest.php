<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportFacade;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Product\Dependency\Plugin\ProductConcretePluginUpdateInterface;

class SalePriceProductConcreteUpdatePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productConcreteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportFacade
     */
    protected MockObject|ProductApiSchedulePriceImportFacade $apiSchedulePriceImportFacadeMock;

    /**
     * @var \Spryker\Zed\Product\Dependency\Plugin\ProductConcretePluginUpdateInterface
     */
    protected ProductConcretePluginUpdateInterface $salePriceProductConcreteCreatePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productConcreteTransferMock = $this->createMock(ProductConcreteTransfer::class);
        $this->apiSchedulePriceImportFacadeMock = $this->createMock(ProductApiSchedulePriceImportFacade::class);

        $this->salePriceProductConcreteCreatePlugin = new SalePriceProductConcreteUpdatePlugin();
        $this->salePriceProductConcreteCreatePlugin->setFacade($this->apiSchedulePriceImportFacadeMock);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->apiSchedulePriceImportFacadeMock->expects(static::once())
            ->method('onUpdateProductConcrete')
            ->with($this->productConcreteTransferMock)
            ->willReturn($this->productConcreteTransferMock);

        $productConcreteTransfer = $this->salePriceProductConcreteCreatePlugin
            ->update($this->productConcreteTransferMock);

        static::assertEquals($productConcreteTransfer, $this->productConcreteTransferMock);
    }
}
