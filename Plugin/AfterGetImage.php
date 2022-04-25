<?php

namespace Scaleflex\Filerobot\Plugin;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Helper\Image;
use Scaleflex\Filerobot\Helper\Filerobot;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class AfterGetImage
{

    /** @var Image  */
    protected $imageHelper;

    /** @var FilerobotConfig  */
    protected FilerobotConfig $fileRobotConfig;

    /** @var Filerobot  */
    protected $filerobotHelper;


    /**
     * @param FilerobotConfig $fileRobotConfig
     * @param Image $imageHelper
     * @param Filerobot $filerobotHelper
     */
    public function __construct(
        FilerobotConfig $fileRobotConfig,
        Image $imageHelper,
        Filerobot $filerobotHelper
    ) {
        $this->imageHelper = $imageHelper;
        $this->fileRobotConfig = $fileRobotConfig;
        $this->filerobotHelper = $filerobotHelper;
    }

    /**
     * @param AbstractProduct $subject
     * @param $result
     * @param $product
     * @param $imageId
     * @param $attributes
     * @return mixed
     */
    public function afterGetImage(AbstractProduct $subject, $result, $product, $imageId, $attributes)
    {
        try {
            if ($product) {
                $images = $product->getMediaAttributeValues();
                if (!empty($images) && $images['image']) {
                    if ($this->fileRobotConfig->isFilerobot($images['image'])) {
                        $image = [];
                        $imageSize = $this->imageHelper->init($product, 'product_base_image');
                        $image['width'] = $imageSize->getWidth();
                        $image['height'] = $imageSize->getHeight();
                        $image['image_url'] = $this->filerobotHelper->buildImageBySize($images['image'], $imageSize->getHeight(), $imageSize->getHeight());
                        $image['ratio'] = "1.25";
                        $image['label'] = $product->getName();
                        $image['custom_attributes'] = [];
                        $image['product_id'] = $product->getId();
                        if ($image) {
                            $result->setData($image);
                        }
                    } else {
                        $result->setData($images['image']);
                    }
                }
            }
        } catch (\Exception $e) {
            //
        }
        return $result;
    }
}
