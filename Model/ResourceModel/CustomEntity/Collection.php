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

namespace Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity;

/**
 * Custom entity collection model.
 *
 * @category Smile
 * @package  Smile\ElasticsuiteCustomEntity
 * @author   Aurelien FOUCRET <aurelien.foucret@smile.fr>
 */
class Collection extends \Magento\Catalog\Model\ResourceModel\Category\Collection
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'custom_entity_collection';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'custom_entity_collection';

    /**
     * Init collection and determine table names
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Smile\ElasticsuiteCustomEntity\Model\CustomEntity',
            'Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity'
        );
    }

    public function addIsActiveFilter()
    {
        $this->addAttributeToFilter('is_active', 1);
        $this->_eventManager->dispatch($this->_eventPrefix . '_add_is_active_filter', [$this->_eventObject => $this]);

        return $this;
    }
}