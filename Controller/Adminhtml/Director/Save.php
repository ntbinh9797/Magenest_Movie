<?php
namespace Magenest\Movie\Controller\Adminhtml\Director;

use Exception;
use Magenest\Movie\Model\DirectorFactory;
use Magenest\Movie\Model\ResourceModel\Director;
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
    /** @var Director  */
    protected $directorResource;

    /** @var RedirectFactory  */
    protected $resultRedirectFactory;

    /**
     * @var DirectorFactory
     */
    protected $directorFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param DirectorFactory $directorFactory
     * @param Director $directorResource
     */
    public function __construct(
        Action\Context $context,
        DirectorFactory $directorFactory,
        Director $directorResource
    ) {
        parent::__construct($context);
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->directorResource= $directorResource;
        $this->directorFactory = $directorFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|ResultInterface
     */
    public function execute()
    {
        try {
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $data           = $this->getRequest()->getPostValue();
            if ($data) {
                $id = $this->getRequest()->getParam('director_id');
                $director = $this->directorFactory->create();
                $this->directorResource->load($director, $id);
                $director->addData($data);
                $this->directorResource->save($director);
                $this->messageManager->addSuccessMessage(__('The Director has been saved.'));
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
        return $this->_authorization->isAllowed('Magenest_Movie::director');
    }
}
