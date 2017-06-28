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

namespace Smile\ElasticsuiteCustomEntity\Setup;

/**
 * Custom Entity EAV Setup.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class CustomEntitySetup extends \Magento\Eav\Setup\EavSetup
{
    /**
     * Installed EAV entities.
     *
     * @return array
     */
    public function getDefaultEntities()
    {
        return [
            'smile_elasticsuite_custom_entity' => [
                'entity_model'                => \Smile\ElasticsuiteCustomEntity\Model\CustomEntity::class,
                'attribute_model'             => \Smile\ElasticsuiteCustomEntity\Model\CustomEntity\Attribute::class,
                'table'                       => 'smile_elasticsuite_custom_entity',
                'attributes'                  => $this->getDefaultAttributes(),
                'additional_attribute_table'  => 'smile_elasticsuite_custom_entity_eav_attribute',
                'entity_attribute_collection' => 'Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity\Attribute\Collection',
            ],
        ];
    }

    /**
     * List of default attributes.
     *
     * @return array
     */
    private function getDefaultAttributes()
    {
        return [
            'name' => [
                'type' => 'varchar',
                'label' => 'Name',
                'input' => 'text',
                'sort_order' => 1,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'General',
            ],
            'is_active' => [
                'type' => 'int',
                'label' => 'Is Active',
                'input' => 'select',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'sort_order' => 2,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'General',
            ],
        ];
    }
}
