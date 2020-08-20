<?php

namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomerFirstName implements ObserverInterface
{
    protected $request;
    protected $layout;
    protected $objectManager = null;
    protected $customerRepositoryInterface;
    protected $customer;

    /**
     * CustomerFirstName constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     */

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Customer\Api\Data\CustomerInterface $customer
    )
    {
        $this->layout = $context->getLayout();
        $this->request = $context->getRequest();
        $this->objectManager = $objectManager;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->customer = $customer;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */

    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $event = $observer->getEvent();
        $this->customer = $event->getData('customer');
        $modifiedFirstname = 'Magenest';
        $this->customer->setFirstName($modifiedFirstname);
        $this->customerRepositoryInterface->save($this->customer);
    }
}