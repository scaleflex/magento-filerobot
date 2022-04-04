<?php

namespace Scaleflex\FileRobot\Plugin;

use Magento\Catalog\Block\Product\View\Gallery;
use Scaleflex\FileRobot\Model\FileRobotConfig;

class AddImageToGallery
{
    protected $fileRobotConfig;

    public function __construct(
        FileRobotConfig $fileRobotConfig
    ) {
        $this->fileRobotConfig = $fileRobotConfig;
    }

    public function afterGetGalleryImages(Gallery $gallery, $images) {
        foreach ($images as $image) {
           if ($this->fileRobotConfig->isFilerobot($image->getData('file'))) {
               $image->setData('url', $image->getData('file'));
               $image->setData('small_image_url', $image->getData('file'));
               $image->setData('medium_image_url', $image->getData('file'));
               $image->setData('large_image_url', $image->getData('file'));
           }
        }
        return $images;
    }
}
