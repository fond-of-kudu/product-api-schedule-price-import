<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceHandler;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductApiSchedulePriceImportFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected MockObject|ProductConcreteTransfer $productAbstractConcreteMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportBusinessFactory
     */
    protected MockObject|ProductApiSchedulePriceImportBusinessFactory $productApiSchedulePriceImportBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceHandler
     */
    protected MockObject|SalePriceHandler $salePriceHandlerMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportFacadeInterface
     */
    protected ProductApiSchedulePriceImportFacadeInterface $apiSchedulePriceImportFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->productAbstractConcreteMock = $this->createMock(ProductConcreteTransfer::class);
        $this->productApiSchedulePriceImportBusinessFactoryMock = $this->createMock(ProductApiSchedulePriceImportBusinessFactory::class);
        $this->salePriceHandlerMock = $this->createMock(SalePriceHandler::class);

        $this->apiSchedulePriceImportFacade = new ProductApiSchedulePriceImportFacade();
        $this->apiSchedulePriceImportFacade->setFactory($this->productApiSchedulePriceImportBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testOnCreateProductAbstract(): void
    {
        $this->productApiSchedulePriceImportBusinessFactoryMock->expects(static::once())
            ->method('createSalePriceHandler')
            ->willReturn($this->salePriceHandlerMock);

        $this->salePriceHandlerMock->expects(static::once())
            ->method('handleProductAbstract')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->productAbstractTransferMock);

        $productAbstractTransfer = $this->apiSchedulePriceImportFacade
            ->onUpdateProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testOnUpdateProductAbstract(): void
    {
        $this->productApiSchedulePriceImportBusinessFactoryMock->expects(static::once())
            ->method('createSalePriceHandler')
            ->willReturn($this->salePriceHandlerMock);

        $this->salePriceHandlerMock->expects(static::once())
            ->method('handleProductAbstract')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->productAbstractTransferMock);

        $productAbstractTransfer = $this->apiSchedulePriceImportFacade
            ->onUpdateProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testOnCreateProductConcrete(): void
    {
        $this->productApiSchedulePriceImportBusinessFactoryMock->expects(static::once())
            ->method('createSalePriceHandler')
            ->willReturn($this->salePriceHandlerMock);

        $this->salePriceHandlerMock->expects(static::atLeastOnce())
            ->method('handleProductConcrete')
            ->with($this->productAbstractConcreteMock)
            ->willReturn($this->productAbstractConcreteMock);

        $productConcreteTransfer = $this->apiSchedulePriceImportFacade
            ->onCreateProductConcrete($this->productAbstractConcreteMock);

        static::assertEquals($productConcreteTransfer, $this->productAbstractConcreteMock);
    }

    /**
     * @return void
     */
    public function testOnUpdateProductConcrete(): void
    {
        $this->productApiSchedulePriceImportBusinessFactoryMock->expects(static::once())
            ->method('createSalePriceHandler')
            ->willReturn($this->salePriceHandlerMock);

        $this->salePriceHandlerMock->expects(static::atLeastOnce())
            ->method('handleProductConcrete')
            ->with($this->productAbstractConcreteMock)
            ->willReturn($this->productAbstractConcreteMock);

        $productConcreteTransfer = $this->apiSchedulePriceImportFacade
            ->onUpdateProductConcrete($this->productAbstractConcreteMock);

        static::assertEquals($productConcreteTransfer, $this->productAbstractConcreteMock);
    }
}
