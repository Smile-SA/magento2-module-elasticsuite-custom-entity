<?php

namespace Smile\ElasticsuiteCustomEntity\Ui\DataProvider;

use Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity\CollectionFactory;

class CustomEntityDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var \Smile\ElasticsuiteCustomEntity\Model\ResourceModel\CustomEntity\Collection
     */
    protected $collection;

    /**
     *
     * @var \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]
     */
    protected $addFieldStrategies;

    /**
     *
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;
    /**
     *
     * @param unknown           $name
     * @param unknown           $primaryFieldName
     * @param unknown           $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array             $addFieldStrategies
     * @param array             $addFilterStrategies
     * @param array             $meta
     * @param array             $data
     */
    public function __construct($name, $primaryFieldName, $requestFieldName, CollectionFactory $collectionFactory, array $addFieldStrategies = [], array $addFilterStrategies = [], array $meta = [], array $data = [])
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection          = $collectionFactory->create();
        $this->addFieldStrategies  = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        if (! $this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();

        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items)
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function addField($field, $alias = null)
    {
        if (isset($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]->addField($this->getCollection(), $field, $alias);
        } else {
            parent::addField($field, $alias);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        if (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]->addFilter($this->getCollection(), $filter->getField(), [
                $filter->getConditionType() => $filter->getValue()
            ]);
        } else {
            parent::addFilter($filter);
        }
    }
}
