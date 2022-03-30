<?php

namespace Scaleflex\FileRobot\Plugin;

use Magento\Catalog\Block\Product\Image;

class AfterGetImageUrl
{

    /**
     * @param Image $image
     * @param $method
     * @return array|null
     */
    public function after__call(Image $image, $result, $method)
    {
        if ($method == 'getImageUrl' && $image->getProductId() > 0) {
            if (str_contains($image->getData('image_url'), 'filerobot')) {
                $result = $image->getData('image_url');
            }
        }
        return $result;
    }
}
