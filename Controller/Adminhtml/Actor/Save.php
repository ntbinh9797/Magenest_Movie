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
    protected $actorResource;

    /** @var RedirectFactory  */
    protected $resultRedirectFactory;

    /**
     * @var ActorFactory
     */
    protected $actorFactory;

    /**
     * @param Action\Context $context
     * @param ActorFactory $actorFactory
     * @param Actor $actorResource
     */
    public function __construct(
        Action\Context $context,
        ActorFactory $actorFactory,
        Actor $actorResource
    ) {
        parent::__construct($context);
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->actorResource= $actorResource;
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
                $actor = $this->actorFactory->create();
                $this->actorResource->load($actor, $id);
                $actor->addData($data);
                $this->actorResource->save($actor);
                $this->messageManager->addSuccessMessage(__('The Actor has been saved.'));
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
        return $this->_authorization->isAllowed('Magenest_Movie::actor');
    }
}
