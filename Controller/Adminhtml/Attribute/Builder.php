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

namespace Smile\ElasticsuiteCustomEntity\Controller\Adminhtml\Attribute;

use Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterface;

/**
 * Custom entity attribute builder
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Builder extends \Smile\ScopedEav\Controller\Adminhtml\Attribute\AbstractBuilder
{
    /**
     * @var \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterfaceFactory
     */
    private $attributeFactory;

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Api\CustomEntityAttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     *
     * @param \Magento\Framework\Registry                                                    $registry            Registry.
     * @param \Magento\Eav\Model\Config                                                      $eavConfig           EAV config.
     * @param \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterfaceFactory $attributeFactory    Attribute factory.
     * @param \Smile\ElasticsuiteCustomEntity\Api\CustomEntityAttributeRepositoryInterface   $attributeRepository Attribute repository.
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Eav\Model\Config $eavConfig,
        \Smile\ElasticsuiteCustomEntity\Api\Data\CustomEntityAttributeInterfaceFactory $attributeFactory,
        \Smile\ElasticsuiteCustomEntity\Api\CustomEntityAttributeRepositoryInterface $attributeRepository
    ) {
        parent::__construct($registry, $eavConfig);

        $this->attributeFactory    = $attributeFactory;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeFactory()
    {
        return $this->attributeFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeRepository()
    {
        return $this->attributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityTypeCode()
    {
        return CustomEntityAttributeInterface::ENTITY_TYPE_CODE;
    }
}
