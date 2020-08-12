<?php
namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\Component\MassAction\Filter;
use Magenest\Movie\Model\ResourceModel\Actor\CollectionFactory;
use Magenest\Movie\Model\ResourceModel\Actor as ActorResource;
use Magenest\Movie\Model\ActorFactory;
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

    /** @var CollectionFactory  */
    protected $collectionFactory;

    /** @var ActorFactory */
    protected $actorFactory;

    /** @var ActorResource  */
    protected $actorResource;

    /**
     * AbstractMassAction constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param ActorResource $actorResource
     * @param ActorFactory $actorFactory
     * @param Filter $filter
     * @param Context $context
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ActorResource $actorResource,
        ActorFactory $actorFactory,
        Filter $filter,
        Context $context
    ){
        $this->collectionFactory = $collectionFactory;
        $this->actorResource = $actorResource;
        $this->actorFactory = $actorFactory;
        $this->filter = $filter;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return Redirect
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
     * Set status to collection items
     *
     * @param AbstractCollection $collection
     * @return ResponseInterface|ResultInterface
     */
    abstract protected function massAction(AbstractCollection $collection);
}