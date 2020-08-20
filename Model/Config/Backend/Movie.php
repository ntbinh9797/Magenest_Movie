<?php

namespace Magenest\Movie\Model\Config\Backend;

class Movie extends \Magento\Framework\App\Config\Value
{
    /**
     * @method string getScope()
     * @method \Magento\Framework\App\Config\ValueInterface setScope(string $value)
     * @method int getScopeId()
     * @method \Magento\Framework\App\Config\ValueInterface setScopeId(int $value)
     * @method string getPath()
     * @method \Magento\Framework\App\Config\ValueInterface setPath(string $value)
     * @method string getValue()
     * @method \Magento\Framework\App\Config\ValueInterface setValue(string $value)
     */
    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     * @var \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory $collectionFactory
     */
    protected $collectionFactory;
    protected $_config;
    protected $cacheTypeList;

    /**
     * @param \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory $collectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->collectionFactory = $collectionFactory;

        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data
        );
    }

    public function getValue()
    {
        $collection = $this->collectionFactory->create();
        return $collection->count();
    }
}


