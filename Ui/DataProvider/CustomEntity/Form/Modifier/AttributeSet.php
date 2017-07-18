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

namespace Smile\ElasticsuiteCustomEntity\Ui\DataProvider\CustomEntity\Form\Modifier;

use Magento\Ui\Component\Form\Field;
use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;

/**
 * Custom entity attribute set edit field management.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class AttributeSet extends \Smile\ScopedEav\Ui\DataProvider\Entity\Form\Modifier\AbstractModifier
{
    /**
     * @var int
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
     * @var \Smile\ScopedEav\Model\Locator\LocatorInterface
     */
    private $locator;

    /**
     * Constructor.
     *
     * @param \Smile\ScopedEav\Model\Locator\LocatorInterface                         $locator             Entity locator.
     * @param \Magento\Framework\UrlInterface                                         $urlBuilder          URL builder.
     * @param \Smile\ElasticsuiteCustomEntity\Model\CustomEntity\AttributeSet\Options $attributeSetOptions Attribute set source model.
     */
    public function __construct(
        \Smile\ScopedEav\Model\Locator\LocatorInterface $locator,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Smile\ElasticsuiteCustomEntity\Model\CustomEntity\AttributeSet\Options $attributeSetOptions
    ) {
        $this->attributeSetOptions = $attributeSetOptions;
        $this->urlBuilder          = $urlBuilder;
        $this->locator             = $locator;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        if ($name = $this->getFirstPanelCode($meta)) {
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
