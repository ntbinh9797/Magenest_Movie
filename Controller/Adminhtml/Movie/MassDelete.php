<?php

namespace Magenest\Movie\Controller\Adminhtml\Movie;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class MassDelete extends AbstractMassAction
{
    /**
     * @param AbstractCollection $collection
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    protected function massAction(AbstractCollection $collection)
    {
        $count = 0;
        foreach ($collection->getItems() as $item) {
            $this->movieResource->delete($item);
            $count++;
        }
        $this->messageManager->addSuccessMessage(__('Total of %1 record(s) have been deleted.', $count));
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->redirectUrl);
        return $resultRedirect;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_Movie::movie_table');
    }
}