<?php

namespace Smile\ElasticsuiteCustomEntity\Ui\DataProvider\CustomEntity\Form;

use Magento\Eav\Api\Data\AttributeGroupInterface;
use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface;
use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;

class CustomEntityAttributes {

    /**
     * @var \Magento\Eav\Api\AttributeGroupRepositoryInterface
     */
    private $attributeGroupRepository;

    /**
     * @var \Magento\Eav\Api\AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder $searchCriteriaBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Ui\DataProvider\Mapper\FormElement
     */
    private $formElementMapper;

    /**
     * @var AttributeGroupInterface[]
     */
    private $attributeGroups = [];

    /**
     * @var CustomEntityAttributeInterface[]
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $canDisplayUseDefault = [];

    public function __construct(
        \Magento\Eav\Api\AttributeGroupRepositoryInterface $attributeGroupRepository,
        \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Ui\DataProvider\Mapper\FormElement $formElementMapper
    ) {
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->attributeRepository      = $attributeRepository;
        $this->searchCriteriaBuilder    = $searchCriteriaBuilder;
        $this->sortOrderBuilder         = $sortOrderBuilder;
        $this->storeManager             = $storeManager;
        $this->formElementMapper        = $formElementMapper;
    }

    public function getGroups($attributeSetId)
    {
        if (!isset($this->attributeGroups[$attributeSetId])) {
            $this->attributeGroups[$attributeSetId] = [];
            $searchCriteria = $this->prepareGroupSearchCriteria($attributeSetId)->create();

            $attributeGroupSearchResult = $this->attributeGroupRepository->getList($searchCriteria);

            foreach ($attributeGroupSearchResult->getItems() as $group) {
                $groupCode = $this->calculateGroupCode($group);
                $this->attributeGroups[$attributeSetId][$groupCode] = $group;
            }
        }

        return $this->attributeGroups[$attributeSetId];
    }

    public function getAttributes($attributeSetId)
    {
        if (!isset($this->attributes[$attributeSetId])) {
            $this->attributes[$attributeSetId] = [];
            foreach ($this->getGroups($attributeSetId) as $group) {
                $groupCode = $this->calculateGroupCode($group);
                $this->attributes[$attributeSetId][$groupCode] = $this->loadAttributes($group);
            }
        }

        return $this->attributes[$attributeSetId];
    }

    public function getScopeLabel(CustomEntityAttributeInterface $attribute)
    {
        if ($this->storeManager->isSingleStoreMode() || $attribute->getFrontendInput() === $attribute::FRONTEND_INPUT) {
            return '';
        }

        switch ($attribute->getScope()) {
            case CustomEntityAttributeInterface::SCOPE_GLOBAL_TEXT:
                return __('[GLOBAL]');
            case CustomEntityAttributeInterface::SCOPE_WEBSITE_TEXT:
                return __('[WEBSITE]');
            case CustomEntityAttributeInterface::SCOPE_STORE_TEXT:
                return __('[STORE VIEW]');
        }

        return '';
    }


    public function canDisplayUseDefault(CustomEntityAttributeInterface $attribute, CustomEntityInterface $entity)
    {
        $attributeCode = $attribute->getAttributeCode();

        if (!isset($this->canDisplayUseDefault[$attributeCode])) {
            $this->canDisplayUseDefault[$attributeCode] = (($attribute->getScope() != $attribute::SCOPE_GLOBAL_TEXT) && $entity->getId() && $entity->getStoreId());
        }

        return $this->canDisplayUseDefault[$attributeCode];
    }

    public function getFormElement($frontendInput)
    {
        $valueMap = $this->formElementMapper->getMappings();

        return isset($valueMap[$frontendInput]) ? $valueMap[$frontendInput] : $frontendInput;
    }

    private function calculateGroupCode(AttributeGroupInterface $group)
    {
        $attributeGroupCode = $group->getAttributeGroupCode();

        return $attributeGroupCode;
    }

    private function prepareGroupSearchCriteria($attributeSetId)
    {
        return $this->searchCriteriaBuilder->addFilter(AttributeGroupInterface::ATTRIBUTE_SET_ID, $attributeSetId);
    }

    private function loadAttributes(AttributeGroupInterface $group)
    {
        $attributes = [];

        $sortOrder = $this->sortOrderBuilder
            ->setField('sort_order')
            ->setAscendingDirection()
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(AttributeGroupInterface::GROUP_ID, $group->getAttributeGroupId())
            ->addSortOrder($sortOrder)
            ->create();

        $groupAttributes = $this->attributeRepository->getList(CustomEntityInterface::ENTITY, $searchCriteria)->getItems();

        foreach ($groupAttributes as $attribute) {
            $attributes[] = $attribute;
        }

        return $attributes;
    }
}