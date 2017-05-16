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
 * Custom entity repository interface.
 *
 * @api
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
interface CustomEntityRepositoryInterface
{
    /**
     * Save a custom entity.
     *
     * @param \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface $entity Saved entity.
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     *
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface $entity);

    /**
     * Get custom entity by id.
     *
     * @param int      $entityId    Entity Id.
     * @param bool     $editMode    Load the entity in edit mode.
     * @param int|null $storeId     Store Id.
     * @param bool     $forceReload Force reload the entity..
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($entityId, $storeId = null, $forceReload = false);

    /**
     * Delete custom entity.
     *
     * @param \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface $entity Deleted entity.
     *
     * @return bool Will returned True if deleted
     *
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface $entity);

    /**
     * Delete custom entity by id.
     *
     * @param int $entityId Deleted entity id.
     *
     * @return bool Will returned True if deleted
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($entityId);

    /**
     * Get custom entity list.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria Search criteria.
     *
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    // TODO
    // public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
