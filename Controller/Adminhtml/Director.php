<?php
namespace Magenest\Movie\Controller\Adminhtml;

use Magenest\Movie\Model\DirectorFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magenest\Movie\Model\ResourceModel\Director\CollectionFactory as CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class Template
 * @package Magenest\Ticket\Controller\Adminhtml
 */
abstract class Director extends Action
{
    /**
     * @var DirectorFactory
     */
    protected $directorFactory;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Page result factory
     *
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Page factory
     *
     * @var Page
     */
    protected $_resultPage;

    /**
     * Mass Action Filter
     *
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * Director constructor.
     * @param DirectorFactory $directorFactory
     * @param Registry $coreRegistry
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     */
    public function __construct(
        DirectorFactory $directorFactory,
        Registry $coreRegistry,
        Context $context,
        PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory,
        Filter $filter
    ) {
        $this->directorFactory = $directorFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_filter = $filter;
        parent::__construct($context);
    }

    /**
     * @return Page|\Magento\Framework\View\Result\Page
     */
    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }

        return $this->_resultPage;
    }
}