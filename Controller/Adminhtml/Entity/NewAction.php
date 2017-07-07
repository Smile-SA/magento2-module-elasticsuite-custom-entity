<?php

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Entity;

class NewAction extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractEntity
{
    /**
     * {@inheritDoc}
     */
    public function execute()
    {
        if (!$this->getRequest()->getParam('set')) {
            return $this->_forward('noroute');
        }

        $entity = $this->entityBuilder->build($this->getRequest());
        $this->_eventManager->dispatch('custom_entity_entity_new_action', ['entity' => $entity]);

        return $this->createActionPage(__('Create entity'));
    }
}
