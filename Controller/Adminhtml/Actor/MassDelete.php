<?php
namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class MassDelete extends AbstractMassAction
{
    protected function massAction(AbstractCollection $collection)
    {
        $count = 0;
        foreach ($collection->getItems() as $item) {
            $this->actorResource->delete($item);
            $count++;
        }
        $this->messageManager->addSuccessMessage(__('Total of %1 record(s) have been deleted.', $count));
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->redirectUrl);
        return $resultRedirect;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Movie::actor');
    }
}