<?php

namespace Scaleflex\Filerobot\Block\Adminhtml;

use \Magento\Framework\View\Element\Template;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class Firerobot extends Template
{

    /**
     * @var FilerobotConfig
     */
    private $fileRobotConfig;

    /**
     * @param Template\Context $context
     * @param FilerobotConfig $fileRobotConfig
     */
    public function __construct(
        Template\Context $context,
        FilerobotConfig $fileRobotConfig
    ) {
        parent::__construct($context);
        $this->fileRobotConfig = $fileRobotConfig;
    }

    /**
     * @return FilerobotConfig
     */
    public function getConfig()
    {
        return $this->fileRobotConfig;
    }
}
