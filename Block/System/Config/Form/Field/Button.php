<?php

namespace Magenest\Movie\Block\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Button extends Field
{
    protected $_template = 'Magenest_Movie::System/Config/Button/button.phtml';

    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }
/** Template of button ->view/templates/System/Config/Button/button.phtml */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Button'
        )->setData(
            [
                'id' => 'button_field',
                'label' => __('Button Field'),
                'onclick' => 'javascript:location.reload(); return true;'
            ]
        );
        return $button->toHtml();
    }
}
