<?php


namespace Magenest\Movie\Block\System\Config\Form\Field;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
class ChangeColor extends Field
{
    /**
     * ChangeColor constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function _renderScopeLabel(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = '<strong>Yes/No_Field_<span style="color:red;">abcd</span></strong>';
        $element->setData('label', $html);
        return parent::_renderScopeLabel($element);
    }
}