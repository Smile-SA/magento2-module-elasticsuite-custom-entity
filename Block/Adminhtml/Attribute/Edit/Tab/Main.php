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
 * Custom entity attribute general properties form.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Main extends \Magento\Eav\Block\Adminhtml\Attribute\Edit\Main\AbstractMain
{
    /**
     * @var string[]
     */
    private $disableScopeChangeList;

    /**
     *
     * @param \Magento\Backend\Block\Template\Context                            $context
     * @param \Magento\Framework\Registry                                        $registry
     * @param \Magento\Framework\Data\FormFactory                                $formFactory
     * @param \Magento\Eav\Helper\Data                                           $eavData
     * @param \Magento\Config\Model\Config\Source\YesnoFactory                   $yesnoFactory
     * @param \Magento\Eav\Model\Adminhtml\System\Config\Source\InputtypeFactory $inputTypeFactory
     * @param \Magento\Eav\Block\Adminhtml\Attribute\PropertyLocker              $propertyLocker
     * @param array                                                              $disableScopeChangeList
     * @param array                                                              $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Eav\Helper\Data $eavData,
        \Magento\Config\Model\Config\Source\YesnoFactory $yesnoFactory,
        \Magento\Eav\Model\Adminhtml\System\Config\Source\InputtypeFactory $inputTypeFactory,
        \Magento\Eav\Block\Adminhtml\Attribute\PropertyLocker $propertyLocker,
        array $disableScopeChangeList = [],
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $eavData, $yesnoFactory, $inputTypeFactory, $propertyLocker, $data);
        $this->disableScopeChangeList = $disableScopeChangeList;
    }

    /**
     * {@inheritDoc}
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();

        $attributeObject = $this->getAttributeObject();

        $form     = $this->getForm();
        $fieldset = $form->getElement('base_fieldset');

        $fieldset->addField(
            'is_global',
            'select',
            [
                'name'   => 'is_global',
                'label'  => __('Scope'),
                'title'  => __('Scope'),
                'note'   => __('Declare attribute value saving scope.'),
                'value'  => $attributeObject->getIsGlobal(),
                'values' => $this->getAttributeScopes(),
            ],
            'attribute_code'
        );

        $form->getElement("attribute_code")->setRequired(false);

        if ($attributeObject->getId()) {
            $form->getElement('attribute_code')->setDisabled(1);
            if (! $attributeObject->getIsUserDefined()) {
                $form->getElement('is_unique')->setDisabled(1);
            }
        }

        if (in_array($attributeObject->getAttributeCode(), $this->disableScopeChangeList)) {
            $form->getElement('is_global')->setDisabled(1);
        }

        return $this;
    }

    /**
     * List of scopes available for attribute.
     *
     * @return \Magento\Framework\Phrase[]
     */
    private function getAttributeScopes() {
        $scopes = [
            \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE => __('Store View'),
            \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_WEBSITE => __('Website'),
            \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL => __('Global')
        ];

        return $scopes;
    }
}
