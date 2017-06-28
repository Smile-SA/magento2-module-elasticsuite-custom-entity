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

class Main extends \Magento\Backend\Block\Template
{

    /**
     *
     * @var string
     */
    protected $_template = 'set/toolbar/main.phtml';

    /**
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->getToolbar()->addChild('addButton', 'Magento\Backend\Block\Widget\Button', [
            'label' => __('Add Attribute Set'),
            'onclick' => 'setLocation(\'' . $this->getUrl('*/*/add') . '\')',
            'class' => 'add primary add-set'
        ]);
        return parent::_prepareLayout();
    }

    /**
     *
     * @return string
     */
    public function getNewButtonHtml()
    {
        return $this->getChildHtml('addButton');
    }

    /**
     *
     * @return \Magento\Framework\Phrase
     */
    protected function _getHeader()
    {
        return __('Attribute Sets');
    }

    /**
     *
     * @return string
     */
    protected function _toHtml()
    {
        $this->_eventManager->dispatch('adminhtml_catalog_product_attribute_set_toolbar_main_html_before', [
            'block' => $this
        ]);
        return parent::_toHtml();
    }
}
