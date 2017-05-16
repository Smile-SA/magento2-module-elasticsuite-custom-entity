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

namespace Smile\ElasticsuiteCustomEntity\Api;

/**
 * Custom entity attribute repository interface.
 *
 * @api
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
interface CustomEntityAttributeRepositoryInterface extends \Magento\Framework\Api\MetadataServiceInterface
{
    /**
     * Retrieve specific attribute.
     *
     * @param string $attributeCode Attribute code.
     *
     * @return \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($attributeCode);

    /**
     * Save attribute data.
     *
     * @param \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface $attribute Attribute.
     *
     * @return \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function save(\Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface $attribute);

    /**
     * Delete Attribute.
     *
     * @param \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface $attribute Attribute.
     *
     * @return bool True if the entity was deleted (always true)
     *
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function delete(\Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface $attribute);

    /**
     * Delete Attribute by id
     *
     * @param string $attributeCode Attribute code.
     *
     * @return bool
     *
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($attributeCode);

    /**
     * Retrieve all attributes for entity type.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria Search criteria.
     *
     * @return \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
