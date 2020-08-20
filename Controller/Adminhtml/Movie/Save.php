<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Exception;
use Magenest\Movie\Model\MovieFactory;
use Magenest\Movie\Model\ResourceModel\Movie;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;


class Save extends Action
{
    /** @var Movie */
    protected $movieResource;

    /** @var RedirectFactory */
    protected $resultRedirectFactory;

    /**
     * @var MovieFactory
     */
    protected $movieFactory;


    /**
     * Save constructor.
     * @param Action\Context $context
     * @param MovieFactory $movieFactory
     * @param Movie $movieResource
     */
    public function __construct(
        Action\Context $context,
        MovieFactory $movieFactory,
        Movie $movieResource
    )
    {
        parent::__construct($context);
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->movieResource = $movieResource;
        $this->movieFactory = $movieFactory;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|ResultInterface
     */
    public function execute()
    {
        try {
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $data = $this->getRequest()->getPostValue();
            if ($data) {
                $id = $this->getRequest()->getParam('movie_id');
                $movie = $this->movieFactory->create();
                $this->movieResource->load($movie, $id);
                $movie->addData($data);
                $this->movieResource->save($movie);
                // Event save_a_movie
                $this->_eventManager->dispatch(
                    'save_a_movie',
                    ['movie' => $movie, 'request' => $this->getRequest()]
                );
                $this->messageManager->addSuccessMessage(__('The Movie has been saved.'));
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Movie::movie_table');
    }
}
