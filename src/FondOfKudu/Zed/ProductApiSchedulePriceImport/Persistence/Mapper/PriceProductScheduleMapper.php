<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper;

use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductScheduleListTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\PriceTypeTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Currency\Persistence\SpyCurrency;
use Orm\Zed\PriceProduct\Persistence\Base\SpyPriceType;
use Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductSchedule;
use Orm\Zed\Store\Persistence\SpyStore;

class PriceProductScheduleMapper implements PriceProductScheduleMapperInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleListMapperInterface
     */
    protected PriceProductScheduleListMapperInterface $priceProductScheduleListMapper;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleListMapperInterface $priceProductScheduleListMapper
     */
    public function __construct(PriceProductScheduleListMapperInterface $priceProductScheduleListMapper)
    {
        $this->priceProductScheduleListMapper = $priceProductScheduleListMapper;
    }

    /**
     * @param \Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductSchedule $priceProductScheduleEntity
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function mapPriceProductScheduleEntityToPriceProductScheduleTransfer(
        SpyPriceProductSchedule $priceProductScheduleEntity,
        PriceProductScheduleTransfer $priceProductScheduleTransfer
    ): PriceProductScheduleTransfer {
        $priceProductTransfer = $this->mapPriceProductScheduleEntityToPriceProductTransfer(
            $priceProductScheduleEntity,
            new PriceProductTransfer(),
        );

        $priceProductScheduleListTransfer = $this->priceProductScheduleListMapper
            ->mapPriceProductScheduleListEntityToPriceProductScheduleListTransfer(
                $priceProductScheduleEntity->getPriceProductScheduleList(),
                new PriceProductScheduleListTransfer(),
            );

        $storeTransfer = $this->mapStoreEntityToStoreTransfer(
            $priceProductScheduleEntity->getStore(),
            new StoreTransfer(),
        );

        return $priceProductScheduleTransfer
            ->fromArray($priceProductScheduleEntity->toArray(), true)
            ->setStore($storeTransfer)
            ->setPriceProduct($priceProductTransfer)
            ->setPriceProductScheduleList($priceProductScheduleListTransfer);
    }

    /**
     * @param \Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductSchedule $priceProductScheduleEntity
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    protected function mapPriceProductScheduleEntityToPriceProductTransfer(
        SpyPriceProductSchedule $priceProductScheduleEntity,
        PriceProductTransfer $priceProductTransfer
    ): PriceProductTransfer {
        $moneyValueTransfer = $this->mapPriceProductScheduleEntityToMoneyValueTransfer(
            $priceProductScheduleEntity,
            new MoneyValueTransfer(),
        );

        $priceTypeTransfer = $this->mapPriceTypeEntityToPriceTypeTransfer(
            $priceProductScheduleEntity->getPriceType(),
            new PriceTypeTransfer(),
        );

        $priceProductDimensionTransfer = $this->mapPriceProductScheduleEntityToPriceProductDimensionTransfer(
            $priceProductScheduleEntity,
            new PriceProductDimensionTransfer(),
        );

        $priceProductTransfer
            ->fromArray($priceProductScheduleEntity->toArray(), true)
            ->setPriceTypeName($priceTypeTransfer->getName())
            ->setPriceType($priceTypeTransfer)
            ->setFkPriceType($priceTypeTransfer->getIdPriceType())
            ->setMoneyValue($moneyValueTransfer)
            ->setPriceDimension($priceProductDimensionTransfer);

        if ($priceProductScheduleEntity->getFkProduct()) {
            $productConcreteEntity = $priceProductScheduleEntity->getProduct();
            $productAbstractEntity = $productConcreteEntity->getSpyProductAbstract();

            $priceProductTransfer->setIdProduct($productConcreteEntity->getIdProduct());
            $priceProductTransfer->setSkuProduct($productConcreteEntity->getSku());
            $priceProductTransfer->setSkuProductAbstract($productAbstractEntity->getSku());
            $priceProductTransfer->setIdProductAbstract($productAbstractEntity->getIdProductAbstract());
        }

        if ($priceProductScheduleEntity->getFkProductAbstract()) {
            $productAbstractEntity = $priceProductScheduleEntity->getProductAbstract();

            $priceProductTransfer->setIdProductAbstract($productAbstractEntity->getIdProductAbstract());
            $priceProductTransfer->setSkuProductAbstract($productAbstractEntity->getSku());
        }

        return $priceProductTransfer;
    }

    /**
     * @param \Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductSchedule $priceProductScheduleEntity
     * @param \Generated\Shared\Transfer\MoneyValueTransfer $moneyValueTransfer
     *
     * @return \Generated\Shared\Transfer\MoneyValueTransfer
     */
    protected function mapPriceProductScheduleEntityToMoneyValueTransfer(
        SpyPriceProductSchedule $priceProductScheduleEntity,
        MoneyValueTransfer $moneyValueTransfer
    ): MoneyValueTransfer {
        $currencyTransfer = $this->mapCurrencyEntityToCurrencyTransfer(
            $priceProductScheduleEntity->getCurrency(),
            new CurrencyTransfer(),
        );

        $storeTransfer = $this->mapStoreEntityToStoreTransfer(
            $priceProductScheduleEntity->getStore(),
            new StoreTransfer(),
        );

        return $moneyValueTransfer
            ->fromArray($priceProductScheduleEntity->toArray(), true)
            ->setNetAmount($priceProductScheduleEntity->getNetPrice())
            ->setGrossAmount($priceProductScheduleEntity->getGrossPrice())
            ->setCurrency($currencyTransfer)
            ->setStore($storeTransfer);
    }

    /**
     * @param \Orm\Zed\Currency\Persistence\SpyCurrency $currencyEntity
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    protected function mapCurrencyEntityToCurrencyTransfer(
        SpyCurrency $currencyEntity,
        CurrencyTransfer $currencyTransfer
    ): CurrencyTransfer {
        return $currencyTransfer
            ->fromArray($currencyEntity->toArray(), true);
    }

    /**
     * @param \Orm\Zed\Store\Persistence\SpyStore $storeEntity
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    protected function mapStoreEntityToStoreTransfer(
        SpyStore $storeEntity,
        StoreTransfer $storeTransfer
    ): StoreTransfer {
        return $storeTransfer->fromArray($storeEntity->toArray(), true);
    }

    /**
     * @param \Orm\Zed\PriceProduct\Persistence\Base\SpyPriceType $spyPriceType
     * @param \Generated\Shared\Transfer\PriceTypeTransfer $priceTypeTransfer
     *
     * @return \Generated\Shared\Transfer\PriceTypeTransfer
     */
    protected function mapPriceTypeEntityToPriceTypeTransfer(
        SpyPriceType $spyPriceType,
        PriceTypeTransfer $priceTypeTransfer
    ): PriceTypeTransfer {
        return $priceTypeTransfer
            ->fromArray($spyPriceType->toArray(), true);
    }

    /**
     * @param \Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductSchedule $priceProductScheduleEntity
     * @param \Generated\Shared\Transfer\PriceProductDimensionTransfer $priceProductDimensionTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductDimensionTransfer
     */
    protected function mapPriceProductScheduleEntityToPriceProductDimensionTransfer(
        SpyPriceProductSchedule $priceProductScheduleEntity,
        PriceProductDimensionTransfer $priceProductDimensionTransfer
    ): PriceProductDimensionTransfer {
        return $priceProductDimensionTransfer
            ->fromArray($priceProductScheduleEntity->getVirtualColumns(), true)
            ->setType('PRICE_DIMENSION_DEFAULT');
    }
}
