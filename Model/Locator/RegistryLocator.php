<?php

namespace Smile\ElasticsuiteCustomEntity\Model\Locator;

use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Class RegistryLocator
 */
class RegistryLocator implements LocatorInterface
{

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     *
     * @var CustomEntityInterface
     */
    private $entity;

    /**
     *
     * @var \Magento\Store\Api\Data\StoreInterface
     */
    private $store;

    public function __construct(\Magento\Framework\Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @throws NotFoundException
     */
    public function getEntity()
    {
        if (null !== $this->entity) {
            return $this->entity;
        }

        if ($entity = $this->registry->registry('current_entity')) {
            return $this->entity = $entity;
        }

        throw new NotFoundException(__('Entity was not registered'));
    }

    /**
     *
     * {@inheritdoc}
     *
     * @throws NotFoundException
     */
    public function getStore()
    {
        if (null !== $this->store) {
            return $this->store;
        }

        if ($store = $this->registry->registry('current_store')) {
            return $this->store = $store;
        }

        throw new NotFoundException(__('Store was not registered'));
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getWebsiteIds()
    {
        return $this->getEntity()->getWebsiteIds();
    }
}
