<?php

namespace Scaleflex\FileRobot\Block\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Scaleflex\FileRobot\Model\FileRobotConfig;

class Button extends Field
{
    /** @var string  */
    protected $_template = 'Scaleflex_FileRobot::system/config/button.phtml';

    /**
     * @var FileRobotConfig
     */
    private $fileRobotConfig;

    /**
     * @param Context $context
     * @param array $data
     * @param FileRobotConfig $fileRobotConfig
     */
    public function __construct(
        Context $context,
        array $data = [],
        FileRobotConfig $fileRobotConfig
    ) {
        parent::__construct($context, $data);
        $this->fileRobotConfig = $fileRobotConfig;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getButtonHtml()
    {
        if ($this->fileRobotConfig->getToken() &&
            $this->fileRobotConfig->getTemplateId() &&
            $this->fileRobotConfig->getUploadDir()) {
            $button = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')->setData(['id' => 'filerobot_test_connection', 'label' => __('Test Connection'),]);
        } else {
            $button = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')->setData(['id' => 'filerobot_test_connection', 'label' => __('Test Connection'), 'disabled' => 'disabled']);
        }

        return $button->toHtml();
    }

    /**
     * @return FileRobotConfig
     */
    public function getConfig() {
        return $this->fileRobotConfig;
    }
}
