<?php


namespace Magenest\Movie\Plugin\Model\Checkout\Cart;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductAround
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var Configurable
     */
    private $configurable;


    /**
     * ProductAround constructor.
     * @param StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     * @param Configurable $configurable
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository,
        Configurable $configurable
    )
    {
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->configurable = $configurable;
    }

    /**
     * @param \Magento\Checkout\Controller\Cart\Add $subject
     * @param \Closure $proceed
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function aroundExecute(
        \Magento\Checkout\Controller\Cart\Add $subject,
        \Closure $proceed
    )
    {

        $productId = (int)$subject->getRequest()->getParam('product'); //get id of product
        if ($product = $this->initProduct($productId)) {
            if ($product->getTypeId() == Configurable::TYPE_CODE) {
                $params = $subject->getRequest()->getParams();
                $childProduct = $this->configurable->getProductByAttributes($params['super_attribute'], $product);
                if ($childProduct->getId()) {
                    $params['product'] = $childProduct->getId();
                    $subject->getRequest()->setParams($params);
                    $imgChildUrl = $childProduct->getData('thumbnail');
                    $nameChild = $childProduct->getData('name');
                    $product->setData('thumbnail', $imgChildUrl);
                    $product->setData('name', $nameChild);
                }
            }
        }

        return $proceed();
    }

    /**
     * @param $productId
     * @return false|\Magento\Catalog\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     */
    protected function initProduct($productId)
    {
        if ($productId) {
            $storeId = $this->storeManager->getStore()->getId();
            try {
                return $this->productRepository->getById($productId, false, $storeId);
            } catch (NoSuchEntityException $e) {
                return false;
            }
        }
        return false;
    }
}