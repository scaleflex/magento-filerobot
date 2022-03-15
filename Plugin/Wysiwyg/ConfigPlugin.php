<?php

namespace Scaleflex\FileRobot\Plugin\Wysiwyg;

use Magento\Cms\Model\Wysiwyg\Config as Subject;
use Magento\Framework\DataObject;
use Scaleflex\FileRobot\Model\Wysiwyg\FileRobot;

class ConfigPlugin
{
    /**
     * @var FileRobot
     */
    private $fileRobot;

    /**
     * ConfigPlugin constructor.
     * @param FileRobot $textWithBox
     */
    public function __construct(
        FileRobot $fileRobot
    )
    {
        $this->fileRobot = $fileRobot;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetConfig(Subject $subject, DataObject $config): DataObject
    {
        $scaleflexFileRobotPlugin = $this->fileRobot->getPluginSettings($config);
        $config->addData($scaleflexFileRobotPlugin);
        return $config;
    }
}
