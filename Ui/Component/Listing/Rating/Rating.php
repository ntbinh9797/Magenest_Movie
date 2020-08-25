<?php


namespace Magenest\Movie\Ui\Component\Listing\Rating;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Rating extends Column
{
    /**
     * Rating constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, array $components = [], array $data = [])
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $html = '';
                $i = 0;
                while ($i < 5) {
                    if ($i < $item['rating']) {
                        $html .= '<img src="https://img.icons8.com/fluent/48/000000/star.png" width="20" height="20">';
                    } else {
                        $html .= '<img src="https://img.icons8.com/color/48/000000/star--v1.png" width="20" height="20">';
                    }
                    $i++;
                }

                $item['rating'] = $html;
            }
        }
        return $dataSource;
    }
}