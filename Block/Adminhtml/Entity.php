<?php

namespace Smile\ElasticsuiteCustomEntity\Block\Adminhtml;

use Magento\Framework\Api\SortOrder;
use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;

class Entity extends \Magento\Backend\Block\Widget\Container
{
    /**
     * @var \Magento\Eav\Model\Config
     */
    private $eavConfig;

    /**
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Catalog\Model\Product\TypeFactory $typeFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Widget\Context $context, \Magento\Eav\Model\Config $eavConfig, array $data = [])
    {
        parent::__construct($context, $data);
        $this->eavConfig = $eavConfig;
    }

    /**
     * Prepare button and grid
     *
     * @return \Magento\Catalog\Block\Adminhtml\Product
     */
    protected function _prepareLayout()
    {
        $addButtonProps = [
            'id' => 'add_new_entity',
            'label' => __('Add'),
            'class' => 'add',
            'button_class' => '',
            'class_name' => 'Magento\Backend\Block\Widget\Button\SplitButton',
            'options' => $this->getAddEntityButtonOptions()
        ];

        $this->buttonList->add('add_new', $addButtonProps);

        return parent::_prepareLayout();
    }

    /**
     * Retrieve options for 'Add Product' split button
     *
     * @return array
     */
    protected function getAddEntityButtonOptions()
    {
        $entityType    = $this->eavConfig->getEntityType(CustomEntityInterface::ENTITY);
        $attributeSets = $entityType->getAttributeSetCollection()->addOrder("attribute_set_name", SortOrder::SORT_ASC);
        $defaultSetId  = $entityType->getDefaultAttributeSetId();

        $splitButtonOptions = [];

        foreach ($attributeSets  as $attributeSet) {
            $splitButtonOptions[$attributeSet->getId()] = [
                'label' => __($attributeSet->getAttributeSetName()),
                'onclick' => "setLocation('" . $this->getEntityCreateUrl($attributeSet->getId()) . "')",
                'default' => $defaultSetId,
            ];
        }

        return $splitButtonOptions;
    }

    /**
     * Retrieve entity create url by specified attribute set id.
     *
     * @param int $attributeSetId Attribute set id.
     *
     * @return string
     */
    protected function getEntityCreateUrl($attributeSetId)
    {
        return $this->getUrl('*/*/new', ['set' => $attributeSetId]);
    }

    /**
     * Check whether it is single store mode
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
        return $this->_storeManager->isSingleStoreMode();
    }
}
