<?php

namespace Scaleflex\FileRobot\Plugin;

use Magento\Catalog\Block\Product\Image;
use Scaleflex\FileRobot\Model\FileRobotConfig;

class AfterGetImageUrl
{

    /**
     * @var FileRobotConfig
     */
    protected FileRobotConfig $fileRobotConfig;

    /**
     * @param FileRobotConfig $fileRobotConfig
     */
    public function __construct(
        FileRobotConfig $fileRobotConfig
    ) {
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
