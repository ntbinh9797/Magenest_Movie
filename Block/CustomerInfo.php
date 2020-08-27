<?php

namespace Magenest\Movie\Block;

use Magento\Framework\UrlInterface;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;

class CustomerInfo extends Template
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;
    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $customerModel;

    /**
     * CustomerInfo constructor.
     * @param Template\Context $context
     * @param SessionFactory $customerSession
     * @param \Magento\Customer\Model\Customer $customerModel
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Session $session
     * @param array $data
     */
    public function __construct(Template\Context $context,SessionFactory $customerSession, \Magento\Customer\Model\Customer $customerModel,\Magento\Store\Model\StoreManagerInterface $storeManager,\Magento\Customer\Model\Session $session, array $data = [])
    {
        $this->storeManager = $storeManager;
        $this->session = $session;
        $this->customerSession = $customerSession->create();
        $this->customerModel = $customerModel;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMediaUrl()
    {
        return $this->getBaseUrl() . 'pub/media/';
    }

    /**
     * @param $filePath
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerImageUrl($filePath)
    {
        return $this->getMediaUrl() . 'customer' . $filePath;
    }

    /**
     * @return false|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getFileUrl()
    {
        $customerData = $this->customerModel->load($this->customerSession->getId());
        $url = $customerData->getData('avatar_customer');
        if (!empty($url)) {
            return $this->getCustomerImageUrl($url);
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        $result = $this->session->getCustomer();
        $info = $result->getData();
        $data['name'] = $info['firstname']." ". $info['lastname'];
        $data['email'] = $info['email'];
        $data['phone'] = isset($info['phone']) ? $info['phone'] : "Not Found";
        return $data;

    }
}
