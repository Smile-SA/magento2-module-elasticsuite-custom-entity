<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Smile Elastic Suite to newer
 * versions in the future.
 *
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteCustomEntity
 * @author    Aurelien FOUCRET <aurelien.foucret@smile.fr>
 * @copyright 2017 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Set\Toolbar;

class Add extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Set\Toolbar\Add
{

    /**
     *
     * @var string
     */
    protected $_template = 'Magento_Catalog::catalog/product/attribute/set/toolbar/add.phtml';

    protected function _prepareLayout()
    {
        if ($this->getToolbar()) {
            $this->getToolbar()->addChild('save_button', 'Magento\Backend\Block\Widget\Button', [
                'label' => __('Save'),
                'class' => 'save primary save-attribute-set',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'save',
                            'target' => '#set-prop-form'
                        ]
                    ]
                ]
            ]);
            $this->getToolbar()->addChild('back_button', 'Magento\Backend\Block\Widget\Button', [
                'label' => __('Back'),
                'onclick' => 'setLocation(\'' . $this->getUrl('*/*/index') . '\')',
                'class' => 'back'
            ]);
        }

        $this->addChild('setForm', 'Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Set\Main\Formset');

        return $this;
    }

}
