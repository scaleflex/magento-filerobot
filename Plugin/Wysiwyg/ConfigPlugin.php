<?php

namespace Scaleflex\Filerobot\Plugin\Wysiwyg;

use Magento\Cms\Model\Wysiwyg\Config as Subject;
use Magento\Framework\DataObject;
use Scaleflex\Filerobot\Model\Wysiwyg\Filerobot;

class ConfigPlugin
{
    /**
     * @var Filerobot
     */
    private $fileRobot;

    /**
     * ConfigPlugin constructor.
     * @param Filerobot $textWithBox
     */
    public function __construct(
        Filerobot $fileRobot
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
