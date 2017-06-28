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

namespace Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Set;

use \Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity\Attribute\CollectionFactory as AttributeCollectionFactory;

/**
 * Custom entity attribute set main form container.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Main extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Set\Main
{
    /**
     * @var string
     */
    protected $_template = 'Magento_Catalog::catalog/product/attribute/set/main.phtml';

    /**
     * Constructor.
     *
     * @param \Magento\Backend\Block\Template\Context                                        $context
     * @param \Magento\Framework\Json\EncoderInterface                                       $jsonEncoder
     * @param \Magento\Eav\Model\Entity\TypeFactory                                          $typeFactory
     * @param \Magento\Eav\Model\Entity\Attribute\GroupFactory                               $groupFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory       $collectionFactory
     * @param \Magento\Framework\Registry                                                    $registry
     * @param \Magento\Catalog\Model\Entity\Product\Attribute\Group\AttributeMapperInterface $attributeMapper
     * @param AttributeCollectionFactory                                                     $attributeCollectionFactory
     * @param array                                                                          $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Eav\Model\Entity\TypeFactory $typeFactory,
        \Magento\Eav\Model\Entity\Attribute\GroupFactory $groupFactory,
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Entity\Product\Attribute\Group\AttributeMapperInterface $attributeMapper,
        \Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity\Attribute\CollectionFactory $attributeCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $jsonEncoder, $typeFactory, $groupFactory, $collectionFactory, $registry, $attributeMapper);
        $this->_collectionFactory = $attributeCollectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getMoveUrl()
    {
        return $this->getUrl('custom_entity/set/save', ['id' => $this->_getSetId()]);
    }

    /**
     * {@inheritDoc}
     */
    protected function _prepareLayout()
    {
        $setId = $this->_getSetId();

        $this->addChild('group_tree', 'Magento\Catalog\Block\Adminhtml\Product\Attribute\Set\Main\Tree\Group');

        $this->addChild('edit_set_form', 'Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Set\Main\Formset');

        $this->addChild('delete_group_button', 'Magento\Backend\Block\Widget\Button', [
            'label' => __('Delete Selected Group'),
            'onclick' => 'editSet.submit();',
            'class' => 'delete'
        ]);

        $this->addChild('add_group_button', 'Magento\Backend\Block\Widget\Button', [
            'label' => __('Add New'),
            'onclick' => 'editSet.addGroup();',
            'class' => 'add'
        ]);

        $this->getToolbar()->addChild('back_button', 'Magento\Backend\Block\Widget\Button', [
            'label' => __('Back'),
            'onclick' => 'setLocation(\'' . $this->getUrl('*/*/index') . '\')',
            'class' => 'back'
        ]);

        $this->getToolbar()->addChild('reset_button', 'Magento\Backend\Block\Widget\Button', [
            'label' => __('Reset'),
            'onclick' => 'window.location.reload()',
            'class' => 'reset'
        ]);

        if (! $this->getIsCurrentSetDefault()) {
            $this->getToolbar()->addChild('delete_button', 'Magento\Backend\Block\Widget\Button', [
                'label' => __('Delete'),
                'onclick' => 'deleteConfirm(\'' . $this->escapeJsQuote(__('You are about to delete all products in this attribute set. ' . 'Are you sure you want to do that?')) . '\', \'' . $this->getUrl('*/*/delete', [
                    'id' => $setId
                ]) . '\')',
                'class' => 'delete'
            ]);
        }

        $this->getToolbar()->addChild('save_button', 'Magento\Backend\Block\Widget\Button', [
            'label' => __('Save'),
            'onclick' => 'editSet.save();',
            'class' => 'save primary save-attribute-set'
        ]);

        $this->addChild('rename_button', 'Magento\Backend\Block\Widget\Button', [
            'label' => __('New Set Name'),
            'onclick' => 'editSet.rename()'
        ]);

        return $this;
    }
}
