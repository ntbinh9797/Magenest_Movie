<?php
namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Exception;
use Magenest\Movie\Model\ActorFactory;
use Magenest\Movie\Model\ResourceModel\Actor;
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
    /** @var Actor  */
    protected $actor;

    /** @var RedirectFactory  */
    protected $resultRedirectFactory;

    /**
     * @var ActorFactory
     */
    protected $actorFactory;

    /**
     * @param Action\Context $context
     * @param ActorFactory $actorFactory
     * @param Actor $actor
     */
    public function __construct(
        Action\Context $context,
        ActorFactory $actorFactory,
        Actor $actor
    ) {
        parent::__construct($context);
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->actor= $actor;
        $this->actorFactory = $actorFactory;
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
                $id = $this->getRequest()->getParam('actor_id');
                $model = $this->actorFactory->create();
                $this->actor->load($model, $id);
                $model->addData($data);
                $this->actor->save($model);
                $this->messageManager->addSuccessMessage(__('The Actor has been saved.'));
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
