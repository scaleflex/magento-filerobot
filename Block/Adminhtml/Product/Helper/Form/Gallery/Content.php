<?php

namespace Scaleflex\Filerobot\Block\Adminhtml\Product\Helper\Form\Gallery;

use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Backend\Block\DataProviders\ImageUploadConfig as ImageUploadConfigDataProvider;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class Content extends \Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery\Content
{

    /** @var FilerobotConfig */
    protected $fileRobotConfig;

    /** @var Database|null */
    protected $fileStorageDatabase;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Catalog\Model\Product\Media\Config $mediaConfig
     * @param array $data
     * @param ImageUploadConfigDataProvider $imageUploadConfigDataProvider
     * @param Database $fileStorageDatabase
     * @param JsonHelper|null $jsonHelper
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context     $context,
        \Magento\Framework\Json\EncoderInterface    $jsonEncoder,
        \Magento\Catalog\Model\Product\Media\Config $mediaConfig,
        array                                       $data = [],
        ImageUploadConfigDataProvider               $imageUploadConfigDataProvider = null,
        Database                                    $fileStorageDatabase = null,
        ?JsonHelper                                 $jsonHelper = null,
        FilerobotConfig                             $fileRobotConfig
    ) {
        parent::__construct($context, $jsonEncoder, $mediaConfig, $data, $imageUploadConfigDataProvider, $fileStorageDatabase, $jsonHelper);
        $this->fileRobotConfig = $fileRobotConfig;
        $this->fileStorageDatabase = $fileStorageDatabase;
    }


    /**
     * @return string
     */
    public function getImagesJson()
    {
        $value = $this->getElement()->getImages();
        if (is_array($value) &&
            array_key_exists('images', $value) &&
            is_array($value['images']) &&
            count($value['images'])
        ) {
            $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA);
            $images = $this->sortImagesByPosition($value['images']);
            foreach ($images as &$image) {
                if ($this->fileRobotConfig->isFilerobot($image['file'])) {
                    $image['url'] = $image['file'];
                    $url = parse_url($image['url']);
                    parse_str($url['query'], $query);
                    $image['size'] = $query['size'];
                } else {
                    $image['url'] = $this->_mediaConfig->getMediaUrl($image['file']);
                    if ($this->fileStorageDatabase->checkDbUsage() &&
                        !$mediaDir->isFile($this->_mediaConfig->getMediaPath($image['file']))
                    ) {
                        $this->fileStorageDatabase->saveFileToFilesystem(
                            $this->_mediaConfig->getMediaPath($image['file'])
                        );
                    }
                    try {
                        $fileHandler = $mediaDir->stat($this->_mediaConfig->getMediaPath($image['file']));
                        $image['size'] = $fileHandler['size'];
                    } catch (FileSystemException $e) {
                        $image['url'] = $this->getImageHelper()->getDefaultPlaceholderUrl('small_image');
                        $image['size'] = 0;
                        $this->_logger->warning($e);
                    }
                }
            }
            return $this->_jsonEncoder->encode($images);
        }
        return '[]';
    }
}
