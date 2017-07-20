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

namespace Smile\ElasticsuiteCustomEntity\Plugin\Catalog\Controller\Adminhtml\Product\Initialization;

/**
 * Plugin for the product save data initialization.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class HelperPlugin
{
    /**
     * @var \Smile\ElasticsuiteCustomEntity\Helper\Data
     */
    private $helper;

    /**
     * Constructor.
     *
     * @param \Smile\ElasticsuiteCustomEntity\Helper\Data $helper Custom entity helper.
     */
    public function __construct(\Smile\ElasticsuiteCustomEntity\Helper\Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Clean custom entity input of the product edit form.
     *
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $helper      Original helper.
     * @param \Magento\Catalog\Model\Product                                      $product     Product.
     * @param array                                                               $productData Post product data.
     *
     * @return array
     */
    public function beforeInitializeFromData(
        \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $helper,
        \Magento\Catalog\Model\Product $product,
        array $productData
    ) {
        foreach ($this->helper->getCustomEntityProductAttributes() as $attribute) {
            if (!isset($productData[$attribute->getAttributeCode()])) {
                $productData[$attribute->getAttributeCode()] = [];
            }
        }

        return [$product, $productData];
    }
}
