<?php

namespace Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Entity\Edit\Button;

class Delete extends Generic
{

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getButtonData()
    {
        if ($this->getEntity()->isReadonly() || !$this->getEntity()->getId()) {
            return [];
        }

        return [
            'label' => __('Delete'),
            'on_click' => sprintf("location.href = '%s';", $this->getUrl('*/*/delete', ['id' => $this->getEntity()->getId()])),
            'class' => 'delete',
            'sort_order' => 20
        ];
    }
}
