<?php

namespace Smile\ElasticsuiteCustomEntity\Ui\DataProvider\CustomEntity\Form\Modifier;

use Magento\Ui\Component\Form\Field;
use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;

class AttributeSet extends AbstractModifier
{
    /**
     * Sort order of "Attribute Set" field inside of fieldset
     */
    const ATTRIBUTE_SET_FIELD_ORDER = 30;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Model\CustomEntity\AttributeSet\Options
     */
    private $attributeSetOptions;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Model\Locator\LocatorInterface
     */
    private $locator;

    public function __construct(
        \Smile\ElasticsuiteCustomEntity\Model\Locator\LocatorInterface $locator,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Smile\ElasticsuiteCustomEntity\Model\CustomEntity\AttributeSet\Options $attributeSetOptions
    ) {
        $this->attributeSetOptions = $attributeSetOptions;
        $this->urlBuilder = $urlBuilder;
        $this->locator    = $locator;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        // TODO : remove this

        if ($name = $this->getGeneralPanelName($meta)) {
            $meta[$name]['children']['attribute_set_id']['arguments']['data']['config'] = [
                'component' => 'Magento_Catalog/js/components/attribute-set-select',
                'disableLabel' => true,
                'filterOptions' => true,
                'elementTmpl' => 'ui/grid/filters/elements/ui-select',
                'formElement' => 'select',
                'componentType' => Field::NAME,
                'options' => $this->attributeSetOptions->toOptionArray(),
                'visible' => 1,
                'required' => 1,
                'label' => __('Attribute Set'),
                'source' => $name,
                'dataScope' => 'attribute_set_id',
                'multiple' => false,
                'sortOrder' => $this->getNextAttributeSortOrder($meta, [CustomEntityInterface::IS_ACTIVE], self::ATTRIBUTE_SET_FIELD_ORDER),
            ];
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $entity = $this->locator->getEntity();
        $data[$entity->getId()][self::DATA_SOURCE_DEFAULT]['attribute_set_id'] = $entity->getAttributeSetId();

        return $data;
    }
}
