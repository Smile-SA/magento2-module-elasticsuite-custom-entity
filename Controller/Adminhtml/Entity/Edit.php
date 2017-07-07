<?php
namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Entity;

class Edit extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractEntity
{
    public function execute()
    {
        $entity   = $this->getEntity();
        $storeId  = $this->getStoreId();
        $entityId = $this->getEntityId();

        if (($entityId && !$entity->getEntityId())) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('This entity doesn\'t exist.'));
            return $resultRedirect->setPath('*/*/');
        } else if ($entityId === 0) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('Invalid entity id. Should be numeric value greater than 0'));
            return $resultRedirect->setPath('*/*/');
        }

        $this->_eventManager->dispatch('custom_entity_entity_edit_action', ['entity' => $entity]);

        $editPage = $this->createActionPage($entity->getName());

        if (!$this->storeManager->isSingleStoreMode() && ($switchBlock = $editPage->getLayout()->getBlock('store_switcher'))) {
            $switchUrl = $this->getUrl('*/*/*', ['_current' => true, 'active_tab' => null, 'tab' => null, 'store' => null]);
            $switchBlock->setDefaultStoreName(__('Default Values'))
                ->setSwitchUrl($switchUrl);
        }

        return $editPage;

//
//         $block = $resultPage->getLayout()->getBlock('catalog.wysiwyg.js');
//         if ($block) {
//             $block->setStoreId($product->getStoreId());
//         }

//         return $resultPage;
    }
}
