<?php

namespace Scaleflex\Filerobot\Plugin\Ui\Component\Wysiwyg;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Scaleflex\Filerobot\Model\FilerobotConfig;


class ConfigPlugin
{

    /**
     * @var \Magento\Ui\Block\Wysiwyg\ActiveEditor
     */
    protected $activeEditor;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;


    /** @var FilerobotConfig */
    private $fileRobotConfig;

    /**
     * ConfigPlugin constructor.
     * @param null $activeEditor
     */
    public function __construct(
        $activeEditor = null,
        RequestInterface $request = null,
        ScopeConfigInterface $scopeConfig = null,
        FilerobotConfig $fileRobotConfig
    ) {
        try {
            if (class_exists(\Magento\Ui\Block\Wysiwyg\ActiveEditor::class)) {
                $this->activeEditor = $activeEditor
                    ?: ObjectManager::getInstance()->get(\Magento\Ui\Block\Wysiwyg\ActiveEditor::class);
            }
        } catch (\Exception $e) {

        }
        $this->fileRobotConfig = $fileRobotConfig;
        $this->request = $request ?: ObjectManager::getInstance()->get(\Magento\Framework\App\RequestInterface::class);
        $this->scopeConfig = $scopeConfig ?: ObjectManager::getInstance()->get(\Magento\Framework\App\Config\ScopeConfigInterface::class);

    }

    /**
     * Enable variables & widgets on product edit page
     *
     * @param \Magento\Ui\Component\Wysiwyg\ConfigInterface $configInterface
     * @param array $data
     * @return array
     */
    public function beforeGetConfig(
        \Magento\Ui\Component\Wysiwyg\ConfigInterface $configInterface,
                                                      $data = []
    ) {
        if (!$this->activeEditor) {
            return [$data];
        }

        $data['add_variables'] = true;
        $data['add_widgets'] = true;

        return [$data];
    }

    /**
     * Return WYSIWYG configuration
     *
     * @param \Magento\Ui\Component\Wysiwyg\ConfigInterface $configInterface
     * @param \Magento\Framework\DataObject $result
     * @return \Magento\Framework\DataObject
     */
    public function afterGetConfig(
        \Magento\Ui\Component\Wysiwyg\ConfigInterface $configInterface,
        \Magento\Framework\DataObject                 $result
    )
    {
        if (!$this->activeEditor) {
            return $result;
        }

        // Get current wysiwyg adapter's path
        $editor = $this->activeEditor->getWysiwygAdapterPath();

        if ($this->fileRobotConfig->checkStatus()) {
            $tinyMCE = $result->getData('tinymce4');
            $toolbar = $tinyMCE['toolbar'];
            $plugins = $tinyMCE['plugins'];
            $tinyMCE['toolbar'] = str_replace('image', '', $toolbar);
            $tinyMCE['plugins'] = str_replace('image', '', $plugins);
            $result->setData('tinymce4', $tinyMCE);

            $tinyPlugins = $result->getData('plugins');
            $newPlugins = [];
            foreach ($tinyPlugins as $item) {
                if ($item['name'] !== 'image') {
                    $newPlugins[] = $item;
                }
            }
            $result->setData('plugins', $newPlugins);
        }

        return $result;
    }

}
