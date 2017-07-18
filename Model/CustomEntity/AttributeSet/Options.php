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

namespace Smile\ElasticsuiteCustomEntity\Model\CustomEntity\AttributeSet;

use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;

/**
 * Custom entity attribute set source model.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Options extends \Magento\Catalog\Model\Product\AttributeSet\Options
{
    /**
     * @var \Magento\Eav\Model\Config
     */
    private $eavConfig;

    /**
     * Constructor.
     *
     * @param \Magento\Eav\Model\Config $eavConfig EAV Config.
     */
    public function __construct(\Magento\Eav\Model\Config $eavConfig)
    {
        $this->eavConfig = $eavConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function toOptionArray()
    {
        $entityType             = $this->eavConfig->getEntityType(CustomEntityInterface::ENTITY);
        $attributeSetCollection = $entityType->getAttributeSetCollection();

        return $attributeSetCollection->toOptionArray();
    }
}
