<?php

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Entity;

use Magento\Framework\Controller\ResultFactory;

class Reload extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\AbstractEntity
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if (! $this->getRequest()->getParam('set')) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('noroute');
        }

        $entity = $this->entityBuilder->build($this->getRequest());

        /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        $resultLayout->getLayout()->getUpdate()->removeHandle('default');

        $resultLayout->setHeader('Content-Type', 'application/json', true);
        return $resultLayout;
    }
}
