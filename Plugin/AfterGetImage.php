<?php

namespace Scaleflex\Filerobot\Plugin;

use Magento\Catalog\Block\Product\AbstractProduct;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class AfterGetImage
{
    /** @var FilerobotConfig  */
    protected FilerobotConfig $fileRobotConfig;

    /**
     * @param FilerobotConfig $fileRobotConfig
     */
    public function __construct(
        FilerobotConfig $fileRobotConfig
    ) {
        $this->fileRobotConfig = $fileRobotConfig;
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
                        //Handle URL
                        $url = parse_url($images['image']);
                        parse_str($url['query'], $query);

                        $image['image_url'] = $images['image'];
                        $image['width'] = !empty($query['width']) ? $query['width'] : '240';
                        $image['height'] = !empty($query['height']) ? $query['height'] : '300';
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
