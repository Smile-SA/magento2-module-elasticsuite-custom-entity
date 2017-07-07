<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ElasticsuiteCustomEntity\Ui\DataProvider\CustomEntity\Form\Modifier;


use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Framework\Stdlib\ArrayManager;
use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;

class Eav extends AbstractModifier
{
    const SORT_ORDER_MULTIPLIER = 10;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Model\Locator\LocatorInterface
     */
    private $locator;

    /**
     * @var \Magento\Framework\Stdlib\ArrayManager
     */
    private $arrayManager;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Ui\DataProvider\CustomEntity\Form\CustomEntityAttributes
     */
    private $entityAttributes;

    /**
     * @var \Magento\Catalog\Model\Attribute\ScopeOverriddenValue
     */
    private $scopeOverriddenValue;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Ui\DataProvider\CustomEntity\Form\CustomEntityEavValidationRules
     */
    private $validationRules;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    private $bannedInputTypes;

    private $attributesToEliminate;

    private $attributesToDisable;


    public function __construct(
        \Smile\ElasticsuiteCustomEntity\Ui\DataProvider\CustomEntity\Form\CustomEntityAttributes $entityAttributes,
        \Smile\ElasticsuiteCustomEntity\Model\Locator\LocatorInterface $locator,
        \Magento\Framework\Stdlib\ArrayManager $arrayManager,
        \Magento\Catalog\Model\Attribute\ScopeOverriddenValue $scopeOverriddenValue,
        \Smile\ScopedEav\Ui\DataProvider\Entity\Form\EavValidationRules $validationRules,
        \Magento\Framework\App\RequestInterface $request,
        $bannedInputTypes = [],
        $attributesToEliminate = [],
        $attributesToDisable = []
    ) {
        $this->entityAttributes = $entityAttributes;
        $this->locator                  = $locator;
        $this->arrayManager             = $arrayManager;
        $this->scopeOverriddenValue     = $scopeOverriddenValue;
        $this->validationRules          = $validationRules;
        $this->request                  = $request;
        $this->bannedInputTypes         = $bannedInputTypes;
        $this->attributesToEliminate    = $attributesToEliminate;
        $this->attributesToDisable      = $attributesToDisable;
    }


    public function modifyData(array $data)
    {
//         if (! $this->locator->getEntity()->getId() && $this->dataPersistor->get('catalog_product')) {
//             return $this->resolvePersistentData($data);
//         }

        $entityId = $this->locator->getEntity()->getId();

        foreach (array_keys($this->getGroups()) as $groupCode) {
            $attributes = ! empty($this->getAttributes()[$groupCode]) ? $this->getAttributes()[$groupCode] : [];

            foreach ($attributes as $attribute) {
                if (null !== ($attributeValue = $this->setupAttributeData($attribute))) {
                    $data[$entityId][self::DATA_SOURCE_DEFAULT][$attribute->getAttributeCode()] = $attributeValue;
                }
            }
        }

        return $data;
    }

    public function modifyMeta(array $meta)
    {
        $sortOrder = 0;

        foreach ($this->getGroups() as $groupCode => $group) {
            $attributes = !empty($this->getAttributes()[$groupCode]) ? $this->getAttributes()[$groupCode] : [];

            if ($attributes) {
                $meta[$groupCode]['children'] = $this->getAttributesMeta($attributes, $groupCode);
                $meta[$groupCode]['arguments']['data']['config']['componentType'] = Fieldset::NAME;
                $meta[$groupCode]['arguments']['data']['config']['label'] = __('%1', $group->getAttributeGroupName());
                $meta[$groupCode]['arguments']['data']['config']['collapsible'] = $groupCode != self::DEFAULT_GENERAL_PANEL;
                $meta[$groupCode]['arguments']['data']['config']['dataScope'] = self::DATA_SCOPE_PRODUCT;
                $meta[$groupCode]['arguments']['data']['config']['sortOrder'] = $sortOrder * self::SORT_ORDER_MULTIPLIER;
            }

            $sortOrder ++;
        }

        return $meta;
    }

    /**
     * Return current attribute set id
     *
     * @return int|null
     */
    private function getAttributeSetId()
    {
        return $this->locator->getEntity()->getAttributeSetId();
    }

    private function getPreviousSetId()
    {
        return (int) $this->request->getParam('prev_set_id', 0);
    }

    private function getGroups()
    {
        return $this->entityAttributes->getGroups($this->getAttributeSetId());
    }

    private function getAttributes()
    {
        return $this->entityAttributes->getAttributes($this->getAttributeSetId());
    }

    private function getPreviousSetAttributes()
    {
        return $this->entityAttributes->getAttributes($this->getPreviousSetId());
    }

    private function getAttributesMeta(array $attributes, $groupCode)
    {
        $meta = [];

        foreach ($attributes as $sortOrder => $attribute) {
            if (in_array($attribute->getFrontendInput(), $this->bannedInputTypes)) {
                continue;
            }

            if (in_array($attribute->getAttributeCode(), $this->attributesToEliminate)) {
                continue;
            }

            if (!($attributeContainer = $this->setupAttributeContainerMeta($attribute))) {
                continue;
            }

            $attributeContainer = $this->addContainerChildren($attributeContainer, $attribute, $groupCode, $sortOrder);

            $meta[self::CONTAINER_PREFIX . $attribute->getAttributeCode()] = $attributeContainer;
        }
        return $meta;
    }


    public function setupAttributeContainerMeta($attribute)
    {
        $containerMeta = $this->arrayManager->set(
            'arguments/data/config',
            [],
            [
                'formElement'   => 'container',
                'componentType' => 'container',
                'breakLine'     => false,
                'label'         => $attribute->getDefaultFrontendLabel(),
                'required'      => $attribute->getIsRequired(),
            ]
        );

        if ($attribute->getIsWysiwygEnabled()) {
            $containerMeta = $this->arrayManager->merge(
                'arguments/data/config',
                $containerMeta,
                ['component' => 'Magento_Ui/js/form/components/group']
            );
        }

        return $containerMeta;
    }

    /**
     * Add container children
     *
     * @param array $attributeContainer
     * @param ProductAttributeInterface $attribute
     * @param string $groupCode
     * @param int $sortOrder
     * @return array @api
     */
    public function addContainerChildren(array $attributeContainer, $attribute, $groupCode, $sortOrder)
    {
        foreach ($this->getContainerChildren($attribute, $groupCode, $sortOrder) as $childCode => $child) {
            $attributeContainer['children'][$childCode] = $child;
        }

        $attributeContainer = $this->arrayManager->merge(
            ltrim(self::META_CONFIG_PATH, ArrayManager::DEFAULT_PATH_DELIMITER),
            $attributeContainer,
            ['sortOrder' => $sortOrder * self::SORT_ORDER_MULTIPLIER, 'scopeLabel' => $this->getScopeLabel($attribute)]
        );

        return $attributeContainer;
    }

    /**
     * Retrieve container child fields
     *
     * @param ProductAttributeInterface $attribute
     * @param string $groupCode
     * @param int $sortOrder
     * @return array @api
     */
    public function getContainerChildren($attribute, $groupCode, $sortOrder)
    {
        if (! ($child = $this->setupAttributeMeta($attribute, $groupCode, $sortOrder))) {
            return [];
        }

        return [
            $attribute->getAttributeCode() => $child
        ];
    }

    public function setupAttributeMeta($attribute, $groupCode, $sortOrder)
    {
        $configPath = ltrim(static::META_CONFIG_PATH, ArrayManager::DEFAULT_PATH_DELIMITER);

        $meta = $this->arrayManager->set($configPath, [], [
                'dataType'    => $attribute->getFrontendInput(),
                'formElement' => $this->entityAttributes->getFormElement($attribute->getFrontendInput()),
                'visible'     => true,
                'required'    => $attribute->getIsRequired(),
                'notice'      => $attribute->getNote(),
                'default'     => $attribute->getDefaultValue(),
                'label'       => $attribute->getDefaultFrontendLabel(),
                'code'        => $attribute->getAttributeCode(),
                'source'      => $groupCode,
                'scopeLabel'  => $this->getScopeLabel($attribute),
                'globalScope' => $this->isScopeGlobal($attribute),
                'sortOrder'   => $sortOrder * self::SORT_ORDER_MULTIPLIER
            ]);

        // TODO: Refactor to $attribute->getOptions() when MAGETWO-48289 is done
        if ($attribute->usesSource()) {
            $meta = $this->arrayManager->merge($configPath, $meta, ['options' => $attribute->getSource()->getAllOptions()]);
        }

        if ($this->canDisplayUseDefault($attribute)) {
            $meta = $this->arrayManager->merge($configPath, $meta, ['service' => ['template' => 'ui/form/element/helper/service']]);
        }

        if (!$this->arrayManager->exists($configPath . '/componentType', $meta)) {
            $meta = $this->arrayManager->merge($configPath, $meta, ['componentType' => Field::NAME]);
        }

        if (in_array($attribute->getAttributeCode(), $this->attributesToDisable)) {
            $meta = $this->arrayManager->merge($configPath, $meta, ['disabled' => true]);
        }

        $childData = $this->arrayManager->get($configPath, $meta, []);
        if (($rules = $this->validationRules->build($attribute, $childData))) {
            $meta = $this->arrayManager->merge($configPath, $meta, ['validation' => $rules]);
        }

        $meta = $this->addUseDefaultValueCheckbox($attribute, $meta);

        switch ($attribute->getFrontendInput()) {
            case 'boolean':
                $meta = $this->customizeCheckbox($attribute, $meta);
                break;
            case 'textarea':
                $meta = $this->customizeWysiwyg($attribute, $meta);
                break;
        }

        return $meta;
    }

    /**
      * Retrieve scope label
      *
      * @param ProductAttributeInterface $attribute
      * @return \Magento\Framework\Phrase|string
      */
    private function getScopeLabel(CustomEntityAttributeInterface $attribute)
    {
        return $this->entityAttributes->getScopeLabel($attribute);
    }

    /**
      * Check if attribute scope is global.
      *
      * @param ProductAttributeInterface $attribute
      * @return bool
      */
    private function isScopeGlobal(CustomEntityAttributeInterface  $attribute)
    {
        return $attribute->getScope() === CustomEntityAttributeInterface::SCOPE_GLOBAL_TEXT;
    }

    /**
      * Whether attribute can have default value
      *
      * @param ProductAttributeInterface $attribute
      * @return bool
      */
    private function canDisplayUseDefault(CustomEntityAttributeInterface $attribute)
    {
        return $this->entityAttributes->canDisplayUseDefault($attribute, $this->locator->getEntity());
    }

    /**
      *
      * @param ProductAttributeInterface $attribute
      * @param array $meta
      * @return array
      */
    private function addUseDefaultValueCheckbox($attribute, array $meta)
    {
        $canDisplayService = $this->canDisplayUseDefault($attribute);
        if ($canDisplayService) {
            $meta['arguments']['data']['config']['service'] = ['template' => 'ui/form/element/helper/service'];

            $meta['arguments']['data']['config']['disabled'] = ! $this->scopeOverriddenValue->containsValue(
                CustomEntityInterface::class,
                $this->locator->getEntity(),
                $attribute->getAttributeCode(),
                $this->locator->getStore()->getId()
            );
        }
        return $meta;
    }

    public function setupAttributeData(CustomEntityAttributeInterface $attribute)
    {
        $entity   = $this->locator->getEntity();
        $entityId = $entity->getId();
        $prevSetId = $this->getPreviousSetId();

        $notUsed = ! $prevSetId || ($prevSetId && ! in_array($attribute->getAttributeCode(), $this->getPreviousSetAttributes()));

        if ($entityId && $notUsed) {
            return $this->getValue($attribute);
        }

        return null;
    }

    private function getValue(CustomEntityAttributeInterface $attribute)
    {
        $entity = $this->locator->getEntity();

        return $entity->getData($attribute->getAttributeCode());
    }
}
