<?php

namespace Scaleflex\Filerobot\Model\Wysiwyg;

use Magento\Framework\DataObject;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class Filerobot
{
    const PLUGIN_NAME = 'filerobot';

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /** @var FilerobotConfig */
    protected $fileRobotConfig;

    /**
     * TextWithBox constructor.
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     */
    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo,
        FilerobotConfig $fileRobotConfig
    ) {
        $this->fileRobotConfig = $fileRobotConfig;
        $this->assetRepo = $assetRepo;
    }

    /**
     * @param DataObject $config
     * @return array
     */
    public function getPluginSettings(DataObject $config): array
    {
        $plugins = $config->getData('plugins');

        if ($this->fileRobotConfig->checkStatus()) {

            $plugins[] = [
                'name' => self::PLUGIN_NAME,
                'src' => $this->getPluginJsSrc(),
                'options' => [
                    'title' => __('File Robot'),
                    'class' => 'file-robot plugin',
                    'css' => $this->getPluginCssSrc()
                ],
            ];
        }

        return ['plugins' => $plugins];
    }

    /**
     * @return string
     */
    private function getPluginJsSrc(): string
    {
        return $this->assetRepo->getUrl(
            sprintf('Scaleflex_Filerobot::js/tiny_mce/plugins/%s/editor_plugin.js', self::PLUGIN_NAME)
        );
    }

    /**
     * @return string
     */
    private function getPluginCssSrc(): string
    {
        return $this->assetRepo->getUrl(
            sprintf('Scaleflex_Filerobot::css/tiny_mce/plugins/%s/content.css', self::PLUGIN_NAME)
        );
    }
}
