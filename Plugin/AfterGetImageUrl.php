<?php

namespace Scaleflex\Filerobot\Plugin;

use Magento\Catalog\Block\Product\Image;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class AfterGetImageUrl
{

    /**
     * @var FilerobotConfig
     */
    protected FilerobotConfig $fileRobotConfig;

    /**
     * @param FilerobotConfig $fileRobotConfig
     */
    public function __construct(
        FilerobotConfig $fileRobotConfig
    )
    {
        $this->fileRobotConfig = $fileRobotConfig;
    }

    /**
     * @param Image $image
     * @param $method
     * @return array|null
     */
    public function after__call(Image $image, $result, $method)
    {
        if ($method == 'getImageUrl' && $image->getProductId() > 0) {
            if ($this->fileRobotConfig->isFilerobot($image->getData('image_url'))) {
                $result = $image->getData('image_url');
            }
        }
        return $result;
    }
}
