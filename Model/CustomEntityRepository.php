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

namespace Smile\ElasticsuiteCustomEntity\Model;

use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Store\Model\StoreManagerInterface;
use Smile\ElasticsuiteCustomEntity\Api\CustomEntityRepositoryInterface;
use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;
use \Smile\ElasticsuiteCustomEntity\Model\CustomEntityFactory;
use \Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity as CustomEntityResource;

/**
 * Custom entity repository implementation.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class CustomEntityRepository implements CustomEntityRepositoryInterface
{
    /**
     * @var CustomEntityInterface[]
     */
    protected $instances = [];

    /**
     * @var CustomEntityResource
     */
    private $customEntityResource;

    /**
     * @var CustomEntityFactory
     */
    private $customEntityFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var MetadataPool
     */
    private $metadataPool;

    /**
     * @var ExtensibleDataObjectConverter
     */
    private $extensibleDataObjectConverter;

    public function __construct(
        CustomEntityFactory $customEntityFactory,
        CustomEntityResource $customEntityResource,
        StoreManagerInterface $storeManager,
        MetadataPool $metadataPool,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->customEntityFactory           = $customEntityFactory;
        $this->customEntityResource          = $customEntityResource;
        $this->storeManager                  = $storeManager;
        $this->metadataPool                  = $metadataPool;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface $entity)
    {
        $existingData = $this->extensibleDataObjectConverter->toNestedArray($entity, [], CustomEntityInterface::class);

        if (!isset($existingData['store_id'])) {
            $existingData['store_id'] = (int) $this->storeManager->getStore()->getId();
        }

        $storeId = $existingData['store_id'];

        if ($entity->getId()) {
            $metadata = $this->metadataPool->getMetadata(CustomEntityInterface::class);

            $entity = $this->get($entity->getId(), $storeId);
            $existingData[$metadata->getLinkField()] = $entity->getData($metadata->getLinkField());
        }
        $entity->addData($existingData);

        try {
            $this->customEntityResource->save($entity);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save entity: %1', $e->getMessage()), $e);
        }
        unset($this->instances[$entity->getId()]);

        return $this->get($entity->getId(), $storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function get($entityId, $storeId = null, $forceReload = false)
    {
        $cacheKey = null !== $storeId ? $storeId : 'all';

        if (!isset($this->instances[$entityId][$cacheKey]) || $forceReload === true) {
            $entity = $this->customEntityFactory->create();
            if (null !== $storeId) {
                $entity->setStoreId($storeId);
            }
            $entity->load($entityId);
            if (!$entity->getId()) {
                throw NoSuchEntityException::singleField('id', $entityId);
            }
            $this->instances[$entityId][$cacheKey] = $entity;
        }

        return $this->instances[$entityId][$cacheKey];
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface $entity)
    {
        try {
            $entityId = $entity->getId();
            $this->customEntityResource->delete($entity);
        } catch (\Exception $e) {
            throw new StateException(__('Cannot delete entity with id %1', $entity->getId()), $e);
        }
        unset($this->instances[$entityId]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($entityId)
    {
        $entity = $this->get($entityId);

        return $this->delete($entity);
    }

    /**
     * {@inheritdoc}
     */
    // public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
