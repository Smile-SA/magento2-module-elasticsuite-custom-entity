<?php

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Entity;

class Builder {

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterfaceFactory
     */
    private $customEntityFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    private $wysiwygConfig;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(
        \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterfaceFactory $customEntityFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $registry,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->customEntityFactory = $customEntityFactory;
        $this->storeManager        = $storeManager;
        $this->registry            = $registry;
        $this->wysiwygConfig       = $wysiwygConfig;
        $this->logger              = $logger;
    }

    /**
     *
     * @param RequestInterface $request
     *
     * @return \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface
     */
    public function build(\Magento\Framework\App\RequestInterface $request)
    {
        $entityId = (int) $request->getParam('id');
        $entity   = $this->customEntityFactory->create();
        $store    = $this->storeManager->getStore($request->getParam('store', 0));

        $entity->setStoreId($store->getId());
        $entity->setData('_edit_mode', true);

        if ($entityId) {
            try {
                $entity->load($entityId);
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }

        $setId = (int) $request->getParam('set');

        if ($setId) {
            $entity->setAttributeSetId($setId);
        }


        $this->registry->register('entity', $entity);
        $this->registry->register('current_entity', $entity);
        $this->registry->register('current_store', $store);
        $this->wysiwygConfig->setStoreId($request->getParam('store'));

        return $entity;
    }
}