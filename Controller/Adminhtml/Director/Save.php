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
    protected $director;

    /** @var RedirectFactory  */
    protected $resultRedirectFactory;

    /**
     * @var DirectorFactory
     */
    protected $directorFactory;

    /**
     * @param Action\Context $context
     * @param DirectorFactory $directorFactory
     * @param Director $director
     */
    public function __construct(
        Action\Context $context,
        DirectorFactory $directorFactory,
        Director $director
    ) {
        parent::__construct($context);
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->director= $director;
        $this->directorFactory = $directorFactory;
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
                $id = $this->getRequest()->getParam('director_id');
                $model = $this->directorFactory->create();
                $this->director->load($model, $id);
                $model->addData($data);
                $this->director->save($model);
                $this->messageManager->addSuccessMessage(__('The Director has been saved.'));
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
