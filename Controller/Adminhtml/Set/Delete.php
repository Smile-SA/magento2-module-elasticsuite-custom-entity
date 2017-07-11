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

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Set;

use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface;

/**
 * Custom entity attribute set deletion controller.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Delete extends \Smile\ScopedEav\Controller\Adminhtml\Set\Delete
{
    /**
     * @var string
     */
    const ADMIN_RESOURCE = 'Smile_ElasticsuiteCustomEntity::attributes_set';

    /**
     * @var string
     */
    protected $entityTypeCode = CustomEntityAttributeInterface::ENTITY_TYPE_CODE;
}
