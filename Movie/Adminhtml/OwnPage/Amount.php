<?php

namespace Magenest\Movie\Block\Adminhtml\OwnPage;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerFactory;
use Magento\Framework\View\Element\Template;

class Amount extends Template
{
    /**
     * @var CustomerFactory
     */
    protected $customerFactory;
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;
    /**
     * @var \Magento\Sales\Model\Order\InvoiceFactory
     */
    protected $invoiceFactory;
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory
     */
    protected $creditmemoFactory;
    /**
     * @var \Magento\Framework\Module\FullModuleList
     */
    protected $fullModuleList;

    /**
     * Amount constructor.
     * @param Template\Context $context
     * @param CustomerFactory $customerFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Sales\Model\Order\InvoiceFactory $invoiceFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory $creditmemoFactory
     * @param \Magento\Framework\Module\FullModuleList $fullModuleList
     * @param array $data
     */
    public function __construct(Template\Context $context,
                                CustomerFactory $customerFactory,
                                \Magento\Catalog\Model\ProductFactory $productFactory,
                                \Magento\Sales\Model\OrderFactory $orderFactory,
                                \Magento\Sales\Model\Order\InvoiceFactory $invoiceFactory,
                                \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory $creditmemoFactory,
                                \Magento\Framework\Module\FullModuleList $fullModuleList,
                                array $data = [])
    {
        $this->customerFactory = $customerFactory;
        $this->productFactory = $productFactory;
        $this->orderFactory = $orderFactory;
        $this->invoiceFactory = $invoiceFactory;
        $this->creditmemoFactory = $creditmemoFactory;
        $this->fullModuleList = $fullModuleList;
        parent::__construct($context, $data);
    }

    public function getAllCustomers()
    {

        $customer = $this->customerFactory->create();
        $allCustomer = $customer->getData();
        return count($allCustomer);
    }

    public function getAllProducts()
    {
        $collection = $this->productFactory->create()->getCollection();

        return count($collection);
    }

    public function getAllOrders()
    {
        $collection = $this->orderFactory->create()->getCollection();
        return count($collection);
    }

    public function getAllInvoices()
    {
        $collection = $this->invoiceFactory->create()->getCollection();
        return count($collection);
    }

    public function getAllCreditMemo()
    {
        $collection = $this->creditmemoFactory->create()->getData();
        return count($collection);
    }

    // count module has first name != Magento => not module of Magento
    public function getFullModuleList()
    {
        $moduleList = $this->fullModuleList->getAll();
        $countModule = 0;
        foreach ($moduleList as $key => $value) {
            $firstNameModule = explode("_", $key);
            if ($firstNameModule[0] != 'Magento') {
                $countModule++;
            }
        }
        return $countModule;
    }

}