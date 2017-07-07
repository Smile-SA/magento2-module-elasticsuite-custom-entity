<?php

namespace Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Entity\Edit\Button;

use Magento\Ui\Component\Control\Container;

class Save extends Generic
{

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getButtonData()
    {
        if ($this->getEntity()->isReadonly()) {
            return [];
        }

        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'custom_entity_entity_form.custom_entity_entity_form',
                                'actionName' => 'save',
                                'params' => [
                                    false
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'class_name' => Container::SPLIT_BUTTON,
            'options' => $this->getOptions(),
            'sort_order' => 30,
        ];
    }

    /**
     * Retrieve options
     *
     * @return array
     */
    protected function getOptions()
    {
        $options[] = [
            'id_hard' => 'save_and_new',
            'label' => __('Save & New'),
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'custom_entity_entity_form.custom_entity_entity_form',
                                'actionName' => 'save',
                                'params' => [
                                    true,
                                    [
                                        'back' => 'new'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $options[] = [
            'id_hard' => 'save_and_close',
            'label' => __('Save & Close'),
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'custom_entity_entity_form.custom_entity_entity_form',
                                'actionName' => 'save',
                                'params' => [
                                    true
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $options;
    }
}
