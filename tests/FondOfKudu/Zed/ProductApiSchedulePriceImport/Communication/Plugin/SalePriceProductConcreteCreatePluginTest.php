<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportFacade;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\ProductExtension\Dependency\Plugin\ProductConcreteCreatePluginInterface;

class SalePriceProductConcreteCreatePluginTest extends Unit
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
     * @var \Spryker\Zed\ProductExtension\Dependency\Plugin\ProductConcreteCreatePluginInterface
     */
    protected ProductConcreteCreatePluginInterface $salePriceProductConcreteCreatePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productConcreteTransferMock = $this->createMock(ProductConcreteTransfer::class);
        $this->apiSchedulePriceImportFacadeMock = $this->createMock(ProductApiSchedulePriceImportFacade::class);

        $this->salePriceProductConcreteCreatePlugin = new SalePriceProductConcreteCreatePlugin();
        $this->salePriceProductConcreteCreatePlugin->setFacade($this->apiSchedulePriceImportFacadeMock);
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
         $this->apiSchedulePriceImportFacadeMock->expects(static::once())
            ->method('onCreateProductConcrete')
            ->with($this->productConcreteTransferMock)
            ->willReturn($this->productConcreteTransferMock);

        $productConcreteTransfer = $this->salePriceProductConcreteCreatePlugin
            ->create($this->productConcreteTransferMock);

        static::assertEquals($productConcreteTransfer, $this->productConcreteTransferMock);
    }
}
