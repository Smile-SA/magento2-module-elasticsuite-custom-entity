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

namespace Smile\ElasticsuiteCustomEntity\Api\Data;

/**
 * Custom entity attribute interface.
 *
 * @api
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
interface CustomEntityAttributeInterface extends \Smile\ScopedEav\Api\Data\AttributeInterface
{
    /**
     * Entity code. Can be used as part of method name for entity processing.
     */
    const ENTITY_TYPE_CODE = 'smile_elasticsuite_custom_entity';
}
