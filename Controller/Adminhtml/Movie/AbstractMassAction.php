<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\Component\MassAction\Filter;
use Magenest\Movie\Model\ResourceModel\Movie\CollectionFactory;
use Magenest\Movie\Model\ResourceModel\Movie as MovieResource;
use Magenest\Movie\Model\MovieFactory;
use \Magento\Backend\App\Action\Context;

/**
 * Class AbstractMassAction
 * @package Magenest\Movie\Controller\Adminhtml\Movie;
 */
abstract class AbstractMassAction extends \Magento\Backend\App\Action
{

    /** @var string */
    protected $redirectUrl = '*/*/';

    /** @var Filter */
    protected $filter;

    /** @var CollectionFactory */
    protected $collectionFactory;

    /** @var MovieFactory */
    protected $movieFactory;

    /** @var MovieResource */
    protected $movieResource;

    /**
     * AbstractMassAction constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param MovieResource $movieResource
     * @param MovieFactory $movieFactory
     * @param Filter $filter
     * @param Context $context
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        MovieResource $movieResource,
        MovieFactory $movieFactory,
        Filter $filter,
        Context $context
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->movieResource = $movieResource;
        $this->movieFactory = $movieFactory;
        $this->filter = $filter;
        parent::__construct($context);
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            return $this->massAction($collection);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath($this->redirectUrl);
        }
    }

    /**
     * @param AbstractCollection $collection
     * @return mixed
     */
    abstract protected function massAction(AbstractCollection $collection);
}