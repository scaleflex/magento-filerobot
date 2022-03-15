<?php

namespace Scaleflex\FileRobot\Block\Adminhtml;

use \Magento\Framework\View\Element\Template;
use Scaleflex\FileRobot\Model\FileRobotConfig;

class FireRobot extends Template
{

    /**
     * @var FileRobotConfig
     */
    private $fileRobotConfig;

    /**
     * @param Template\Context $context
     * @param array $data
     * @param FileRobotConfig $fileRobotConfig
     */
    public function __construct(
        Template\Context $context,
        array $data = [],
        FileRobotConfig $fileRobotConfig
    ) {
        parent::__construct($context, $data);
        $this->fileRobotConfig = $fileRobotConfig;
    }

    /**
     * @return FileRobotConfig
     */
    public function getConfig() {
        return $this->fileRobotConfig;
    }
}
