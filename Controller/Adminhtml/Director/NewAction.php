<?php

namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends \Magento\Backend\App\Action
{
    /** @var PageFactory  */
    protected $resultPageFactory;

    /**
     * NewAction constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ){
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Director Information'));
        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Movie::director');
    }
}