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

use Smile\ElasticsuiteCustomEntity\Api\CustomEntityAttributeRepositoryInterface;

/**
 * Custom entity repository implementation.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class CustomEntityAttributeRepository implements CustomEntityAttributeRepositoryInterface
{
    /**
     * @var \Magento\Eav\Api\AttributeRepositoryInterface
     */
    private $eavAttributeRepository;

    /**
     * Constructor.
     *
     * @param \Magento\Eav\Api\AttributeRepositoryInterface $eavAttributeRepository Base repository.
     */
    public function __construct(
        \Magento\Eav\Api\AttributeRepositoryInterface $eavAttributeRepository
    ) {
        $this->eavAttributeRepository = $eavAttributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function get($attributeCode)
    {
        return $this->eavAttributeRepository->get($this->getEntityTypeCode(), $attributeCode);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(\Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface $attribute)
    {
        return $this->eavAttributeRepository->delete($attribute);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById($attributeCode)
    {
        if (!is_numeric($attributeCode)) {
            $attributeCode = $this->eavAttributeRepository->get($this->getEntityTypeCode(), $attributeCode)->getAttributeId();
        }

        return $this->eavAttributeRepository->deleteById($attributeCode);
    }

    /**
     * {@inheritDoc}
     */
    public function save(\Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface $attribute)
    {
        return $this->eavAttributeRepository->save($attribute);
    }

    /**
     * {@inheritDoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomAttributesMetadata($dataObjectClassName = null)
    {
        // TODO: Implement getCustomAttributesMetadata() method.
    }

    /**
     * Get the custom entity type code.
     *
     * @return string
     */
    private function getEntityTypeCode()
    {
        return \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface::ENTITY_TYPE_CODE;
    }
}
