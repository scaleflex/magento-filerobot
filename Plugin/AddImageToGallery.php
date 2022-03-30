<?php

namespace Scaleflex\FileRobot\Plugin;

use Magento\Catalog\Block\Product\View\Gallery;

class AddImageToGallery
{
    public function afterGetGalleryImages(Gallery $gallery, $images) {
        foreach ($images as $image) {
           if (str_contains($image->getData('file'), 'filerobot')) {
               $image->setData('url', $image->getData('file'));
               $image->setData('small_image_url', $image->getData('file'));
               $image->setData('medium_image_url', $image->getData('file'));
               $image->setData('large_image_url', $image->getData('file'));
           }
        }
        return $images;
    }
}
