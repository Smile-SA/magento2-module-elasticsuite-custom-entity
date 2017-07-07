<?php

namespace Smile\ElasticsuiteCustomEntity\Model\Locator;

use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;
use Magento\Store\Api\Data\StoreInterface;

interface LocatorInterface
{
    /**
     *
     * @return CustomEntityInterface
     */
    public function getEntity();

    /**
     *
     * @return StoreInterface
     */
    public function getStore();

    /**
     *
     * @return array
     */
    public function getWebsiteIds();
}