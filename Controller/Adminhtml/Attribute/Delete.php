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
 * Custom entity attribute deletion controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Delete extends \Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            $attributeId = $this->getRequest()->getParam('attribute_id');
            if ($attributeId) {
                $this->attributeRepository->deleteById($attributeId);
                $this->messageManager->addSuccess(__('Attribute has been deleted'));
                $response = $this->_redirect("*/*/index");
            }
        } catch (\Exception $e) {
            $response = $this->getRedirectError($e->getMessage());
        }

        return $response;
    }
}
