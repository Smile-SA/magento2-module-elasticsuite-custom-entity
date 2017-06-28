<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteCustomEntity
 * @author    Aurelien FOUCRET <aurelien.foucret@smile.fr>
 * @copyright 2017 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Attribute\Edit;

/**
 * Custom entity attribute edit form tabs management.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('custom_entity_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Attribute Information'));
    }

    /**
     * {@inheritDoc}
     */
    protected function _beforeToHtml()
    {
        $this->addTab('main', [
            'label' => __('Properties'),
            'title' => __('Properties'),
            'content' => $this->getChildHtml('main'),
            'active' => true
        ]);
        $this->addTab('labels', [
            'label' => __('Manage Labels'),
            'title' => __('Manage Labels'),
            'content' => $this->getChildHtml('labels')
        ]);
        $this->addTab('front', [
            'label' => __('Storefront Properties'),
            'title' => __('Storefront Properties'),
            'content' => $this->getChildHtml('front')
        ]);

        return parent::_beforeToHtml();
    }
}
