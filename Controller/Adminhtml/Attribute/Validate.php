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
 * Custom entity attribute validation controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Validate extends \Smile\ScopedEav\Controller\Adminhtml\Attribute\Validate
{
    /**
     * @var string
     */
    const ADMIN_RESOURCE = 'Smile_ElasticsuiteCustomEntity::attributes_attributes';

    /**
     * Constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context          Context.
     * @param \Smile\ScopedEav\Helper\Data        $entityHelper     Entity helper.
     * @param Builder                             $attributeBuilder Attribute builder.
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Smile\ScopedEav\Helper\Data $entityHelper,
        Builder $attributeBuilder,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context, $entityHelper, $attributeBuilder, $resultJsonFactory);
    }
}
