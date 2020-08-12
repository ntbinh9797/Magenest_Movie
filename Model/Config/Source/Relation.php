<?php
namespace Magenest\Movie\Model\Config\Source;
class Relation implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            [
                'label' => __('--Please Select--'),'value' => null
            ],
            [
                'label' => __('Show'),
                'value' => '1'
            ],
            [
                'label' => __('Not-Show'),
                'value' => '2'
            ],
        ];
    }
}