<?php
namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Exception;
use Magenest\Movie\Model\MovieFactory;
use Magenest\Movie\Model\ResourceModel\Movie;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * @package Magenest\InstagramShop\Controller\Adminhtml\Hotspot
 */
class Save extends Action
{
    /** @var Movie  */
    protected $movie;

    /** @var RedirectFactory  */
    protected $resultRedirectFactory;

    /**
     * @var MovieFactory
     */
    protected $movieFactory;

    /**
     * @param Action\Context $context
     * @param MovieFactory $movieFactory
     * @param Movie $movie
     */
    public function __construct(
        Action\Context $context,
        MovieFactory $movieFactory,
        Movie $movie
    ) {
        parent::__construct($context);
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->movie= $movie;
        $this->movieFactory = $movieFactory;
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        try {
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $data           = $this->getRequest()->getPostValue();
            if ($data) {
                $id = $this->getRequest()->getParam('movie_id');
                $model = $this->movieFactory->create();
                $this->movie->load($model, $id);
                $model->addData($data);
                $this->movie->save($model);
                $this->messageManager->addSuccessMessage(__('The Movie has been saved.'));
                if (isset($id)) {
                    return $resultRedirect->setPath('*/*/');
                }
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}
