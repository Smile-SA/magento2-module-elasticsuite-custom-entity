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
 * Custom entity attribute search result interface.
 *
 * @api
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
interface CustomEntityAttributeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface[] $items Items.
     *
     * @return $this
     */
    public function setItems(array $items);
}
