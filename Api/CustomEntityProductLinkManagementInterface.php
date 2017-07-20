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

use Magento\Catalog\Api\Data\ProductInterface;
use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityInterface;

/**
 * Custom entity product link management.
 *
 * @api
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
interface CustomEntityProductLinkManagementInterface
{
    /**
     * Return custom entities assigned to a product.
     *
     * @param ProductInterface $product Product.
     *
     * return CustomEntityInterface[]
     */
    public function getCustomEntities(ProductInterface $product);

    /**
     * Persists custom entities product links.
     *
     * @param ProductInterface $product Product.
     *
     * @return ProductInterface
     */
    public function saveCustomEntities(ProductInterface $product);
}
