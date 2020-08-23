<?php

namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;

class MovieRating implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;
    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $layout;
    /**
     * @var \Magento\Framework\ObjectManagerInterface|null
     */
    protected $objectManager = null;
    /**
     * @var \Magenest\Movie\Model\MovieFactory
     */
    protected $movie;
    /**
     * @var \Magenest\Movie\Model\ResourceModel\Movie
     */
    protected $movieResource;

    /**
     * MovieRating constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magenest\Movie\Model\ResourceModel\Movie $movieResource
     * @param \Magenest\Movie\Model\MovieFactory $movie
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magenest\Movie\Model\ResourceModel\Movie $movieResource,
        \Magenest\Movie\Model\MovieFactory $movie
    )
    {
        $this->layout = $context->getLayout();
        $this->request = $context->getRequest();
        $this->objectManager = $objectManager;
        $this->movieResource = $movieResource;
        $this->movie = $movie;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $event = $observer->getEvent();
        $this->movie = $event->getData('movie');
        $this->movie->setRating(0);
        $this->movieResource->save($this->movie);
    }
}