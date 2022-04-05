<?php

namespace Scaleflex\Filerobot\Observer;

use Magento\Framework\Event\ObserverInterface;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class ChangeTemplateObserver implements ObserverInterface
{
    protected $fileRobotConfig;

    public function __construct(
        FilerobotConfig $fileRobotConfig
    ) {
        $this->fileRobotConfig = $fileRobotConfig;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->fileRobotConfig->checkStatus()) {
            $observer->getBlock()
                ->setTemplate('Scaleflex_Filerobot::helper/gallery.phtml');
        }
    }
}
