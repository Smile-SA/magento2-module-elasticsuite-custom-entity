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

/**
 * Custom entity attribute edit controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Edit extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            $title     = __('New attribute');
            $attribute = $this->getAttribute();
            if ($attribute->getId()) {
                $title = __('Edit %1', $attribute->getAttributeCode());
            }
            $response = $this->createActionPage($title);
        } catch (\Exception $e) {
            $response = $this->getRedirectError($e->getMessage());
        }

        return $response;
    }
}
