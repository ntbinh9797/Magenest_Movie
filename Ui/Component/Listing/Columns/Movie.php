<?php
namespace Magenest\Movie\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Movie extends Column
{
    /**
     * URL builder
     *
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * constructor
     *
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['movie_id'])) {
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl("movie/movie/newAction",
                            ['id' => $item['movie_id']]),
                        'label' => __('Edit'),
                    ];
                }else{
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl("movie/movie/newAction",
                            ['id' => $item['movie_id']]),
                        'label' => __('Edit'),
                    ];
                }

            }
        }
        return $dataSource;
    }
}