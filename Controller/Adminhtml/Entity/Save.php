<?php

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action;
use Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractEntity;

class Save extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractEntity
{
    /**
     *
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    private $dataPersistor;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Builder $entityBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context, $entityBuilder, $storeManager, $pageFactory);
        $this->dataPersistor = $dataPersistor;
    }

    public function execute()
    {
        $storeId      = $this->getRequest()->getParam('store', 0);
        $redirectBack = $this->getRequest()->getParam('back', false);

        $entityId = $this->getRequest()->getParam('id');

        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();
        $attributeSetId = $this->getRequest()->getParam('set');


        if ($data) {
            try {
                $entity = $this->entityBuilder->build($this->getRequest());
                $entity->addData($data['entity']);
                $entity->save();

                $entityId       = $entity->getEntityId();
                $attributeSetId = $entity->getAttributeSetId();

                // TODO : Required for entities ? => $this->copyToStores($data, $entityId);

                $this->messageManager->addSuccessMessage(__('You saved the entity.'));
                $this->dataPersistor->clear('custom_entity');

                $this->_eventManager->dispatch(
                    'controller_action_custom_entity_entity_save_entity_after',
                    ['controller' => $this, 'entity' => $entity]
                );

                $resultRedirect->setPath('*/*/index', ['store' => $storeId]);

            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->dataPersistor->set('custom_entity', $data);
                $redirectBack = $entityId ? true : 'new';
            } catch (\Exception $e) {
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->messageManager->addError($e->getMessage());
                $this->dataPersistor->set('custom_entity', $data);
                $redirectBack = $entityId ? true : 'new';
            }
        } else {
            $resultRedirect->setPath('*/*/index', ['store' => $storeId]);
            $this->messageManager->addError('No data to save');
            return $resultRedirect;
        }

        if ($redirectBack === 'new') {
            $resultRedirect->setPath('*/*/new', ['set' => $attributeSetId]);
        } elseif ($redirectBack) {
            $resultRedirect->setPath('*/*/edit', ['id' => $entityId,'_current' => true, 'set' => $attributeSetId, 'storeId' => $storeId]);
        }

        return $resultRedirect;
    }
}
