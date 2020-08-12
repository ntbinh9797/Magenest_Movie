<?php
namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class MassDelete extends AbstractMassAction
{
    protected function massAction(AbstractCollection $collection)
    {
        $count = 0;
        foreach ($collection->getItems() as $item) {
            $this->directorResource->delete($item);
            $count++;
        }
        $this->messageManager->addSuccessMessage(__('Total of %1 record(s) have been deleted.', $count));
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->redirectUrl);
        return $resultRedirect;
    }
}