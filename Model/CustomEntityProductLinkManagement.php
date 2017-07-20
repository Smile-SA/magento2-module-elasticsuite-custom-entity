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

use Smile\ElasticsuiteCustomEntity\Api\CustomEntityProductLinkManagementInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Smile\ElasticsuiteCustomEntity\Api\CustomEntityRepositoryInterface;

/**
 * Custom entity product link management implementation.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class CustomEntityProductLinkManagement implements CustomEntityProductLinkManagementInterface
{
    /**
     * @var ResourceModel\CustomEntityProductLinkManagement
     */
    private $resourceModel;

    /**
     * @var CustomEntityRepositoryInterface
     */
    private $customEntityRepository;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Helper\Data
     */
    private $helper;

    /**
     * Constructor.
     *
     * @param ResourceModel\CustomEntityProductLinkManagement                     $resourceModel          Resource model.
     * @param \Smile\ElasticsuiteCustomEntity\Api\CustomEntityRepositoryInterface $customEntityRepository Custom entity repository.
     * @param \Smile\ElasticsuiteCustomEntity\Helper\Data                         $helper                 Custom entity helper.
     */
    public function __construct(
        ResourceModel\CustomEntityProductLinkManagement $resourceModel,
        \Smile\ElasticsuiteCustomEntity\Api\CustomEntityRepositoryInterface $customEntityRepository,
        \Smile\ElasticsuiteCustomEntity\Helper\Data $helper
    ) {
        $this->resourceModel          = $resourceModel;
        $this->customEntityRepository = $customEntityRepository;
        $this->helper                 = $helper;
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomEntities(ProductInterface $product)
    {
        $entities = [];

        foreach ($this->resourceModel->loadCustomEntityData($product->getId()) as $linkData) {
            $customEntity = $this->customEntityRepository->get($linkData['custom_entity_id'], $product->getStoreId());
            $entities[$linkData['attribute_code']][] = $customEntity;
        }

        return $entities;
    }

    /**
     * {@inheritDoc}
     */
    public function saveCustomEntities(ProductInterface $product)
    {
        foreach ($this->helper->getCustomEntityProductAttributes() as $attribute) {
            $entityIds = $product->getData($attribute->getAttributeCode());

            if (!$entityIds) {
                $entityIds = [];
            }

            $this->resourceModel->saveLinks($product->getId(), $attribute->getId(), $entityIds);
        }

        return $product;
    }
}
