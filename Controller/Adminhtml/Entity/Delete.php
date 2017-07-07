<?php
namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Entity;

class Delete extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractEntity
{
    public function execute()
    {
        $entity   = $this->getEntity();
        $storeId  = $this->getStoreId();
        $entityId = $this->getEntityId();

        if (($entityId && !$entity->getEntityId())) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('This entity doesn\'t exist.'));
        } else if ($entityId === 0) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addErrorMessage(__('Invalid entity id. Should be numeric value greater than 0'));
        } else {
            $this->_eventManager->dispatch('custom_entity_entity_delete_action', ['entity' => $entity]);

            try {
                $entity->delete();
                $this->messageManager->addSuccessMessage(__('Entity have been deleted successfuly.'));
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Can not delete entity.'));
            }
        }

        return $this->_redirect("*/*/");
    }
}
