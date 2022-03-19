<?php

namespace Scaleflex\FileRobot\Observer;

use Magento\Framework\Event\ObserverInterface;

class ChangeTemplateObserver implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $observer->getBlock()
                 ->setTemplate('Scaleflex_FileRobot::helper/gallery.phtml');
    }
}
