<?php

namespace Scaleflex\FileRobot\Observer;

use Magento\Framework\Event\ObserverInterface;
use Scaleflex\FileRobot\Model\FileRobotConfig;

class ChangeTemplateObserver implements ObserverInterface
{
    protected $fileRobotConfig;

    public function __construct(
      FileRobotConfig $fileRobotConfig
    ) {
        $this->fileRobotConfig = $fileRobotConfig;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($this->fileRobotConfig->checkStatus()) {
            $observer->getBlock()
                ->setTemplate('Scaleflex_FileRobot::helper/gallery.phtml');
        }
    }
}
