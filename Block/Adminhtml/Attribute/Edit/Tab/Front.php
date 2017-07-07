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

namespace Smile\ElasticsuiteCustomEntity\Block\Adminhtml\Attribute\Edit\Tab;

/**
 * Custom entity attribute store front properties form.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Front extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var Yesno
     */
    private $yesNo;

    /**
     * Constructor.
     *
     * @param \Magento\Backend\Block\Template\Context   $context     Context.
     * @param \Magento\Framework\Registry               $registry    Registry.
     * @param \Magento\Framework\Data\FormFactory       $formFactory Form factory.
     * @param \Magento\Config\Model\Config\Source\Yesno $yesNo       Yes/No source model
     * @param array                                     $data        Additional data.
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Source\Yesno $yesNo,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->yesNo = $yesNo;
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _prepareForm()
    {
        $attributeObject = $this->getAttributeObject();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $fieldset = $form->addFieldset('front_fieldset', ['legend' => __('Storefront Properties')]);

        $fieldset->addField('is_wysiwyg_enabled', 'select', [
            'name' => 'is_wysiwyg_enabled',
            'label' => __('Enable WYSIWYG'),
            'title' => __('Enable WYSIWYG'),
            'values' => $this->yesNo->toOptionArray(),
        ]);

        $fieldset->addField('is_html_allowed_on_front', 'select', [
            'name' => 'is_html_allowed_on_front',
            'label' => __('Allow HTML Tags on Storefront'),
            'title' => __('Allow HTML Tags on Storefront'),
            'values' => $this->yesNo->toOptionArray(),
        ]);

        $this->setForm($form);
        $form->setValues($attributeObject->getData());

        return parent::_prepareForm();
    }

    /**
     * Retrieve attribute object from registry
     *
     * @return \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface
     */
    private function getAttributeObject()
    {
        return $this->_coreRegistry->registry('entity_attribute');
    }
}
