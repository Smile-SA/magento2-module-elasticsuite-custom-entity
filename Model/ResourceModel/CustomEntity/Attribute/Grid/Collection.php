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

namespace Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity\Attribute\Grid;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity\Attribute\Collection as AttributeCollection;

/**
 * Custom entity attribute collection (grid).
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Collection extends AttributeCollection implements SearchResultInterface
{

    /**
     * @var AggregationInterface
     */
    private $aggregations;

    /**
     * {@inheritDoc}
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * {@inheritDoc}
     * Not implemented since useless.
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * {@inheritDoc}
     * Not implemented since useless.
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     * Not implemented since useless.
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            \Magento\Framework\View\Element\UiComponent\DataProvider\Document::class,
            \Magento\Eav\Model\ResourceModel\Entity\Attribute::class
        );
    }
}
