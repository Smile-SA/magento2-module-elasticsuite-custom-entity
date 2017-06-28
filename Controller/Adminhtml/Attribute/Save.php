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

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute;

use Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute;

/**
 * Custom entity attribute save controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Save extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            $attribute = $this->getAttribute();
            $attribute = $this->getPostData($attribute);

            $this->attributeRepository->save($attribute);

            $response = $this->_redirect("*/*/index");

            if ($this->getRequest()->getParam('back', false)) {
                $response = $this->_redirect("*/*/edit", ['attribute_id' => $attribute->getId(), '_current' => true]);
            }

        } catch (\Exception $e) {
            $response = $this->getRedirectError($e->getMessage());
        }


        return $response;
    }

    private function getPostData(\Smile\ElasticsuiteCustomEntity\Model\CustomEntity\Attribute $attribute)
    {
        $data = array_filter($this->getRequest()->getParams());

        $frontendInput = isset($data['frontend_input']) ? $data['frontend_input'] : $attribute->getFrontendInput();

        if (!$attribute->getId()) {
            $data['attribute_code']  = $this->getAttributeCode();
            $data['is_user_defined'] = true;
            $data['backend_type']    = $attribute->getBackendTypeByInput($data['frontend_input']);
            $data['source_model']  = $this->customEntityHelper->getAttributeSourceModelByInputType($data['frontend_input']);
            $data['backend_model'] = $this->customEntityHelper->getAttributeBackendModelByInputType($data['frontend_input']);
        }

        $defaultValueField = $attribute->getDefaultValueByInput($frontendInput);
        if ($defaultValueField) {
            $data['default_value'] = $this->getRequest()->getParam($defaultValueField);
        }

        $attribute->addData($data);

        return $attribute;
    }

    private function getAttributeCode()
    {
        $attributeCode = $this->getRequest()->getParam('attribute_code') ?: $this->generateCode($this->getRequest()
            ->getParam('frontend_label')[0]);

        if (strlen($attributeCode) > 0) {
            $validatorAttrCode = new \Zend_Validate_Regex(['pattern' => '/^[a-z][a-z_0-9]{0,30}$/']);

            if (!$validatorAttrCode->isValid($attributeCode)) {
                throw new \Exception(__('Attribute code "%1" is invalid. Please use only letters (a-z), ' . 'numbers (0-9) or underscore(_) in this field, first character should be a letter.', $attributeCode));
            }
        }

        return $attributeCode;
    }
}
