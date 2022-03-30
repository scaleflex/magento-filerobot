<?php

namespace Scaleflex\FileRobot\Plugin;

use Magento\Catalog\Block\Product\AbstractProduct;

class AfterGetImage
{
    public function afterGetImage(AbstractProduct $subject, $result, $product, $imageId, $attributes) {
        try {
            if ($product) {
                $images = $product->getMediaAttributeValues();
                if (!empty($images) && $images['image']) {
                    if (str_contains($images['image'], 'filerobot')) {
                        $image              = [];
                        $image['image_url'] = $images['image'];
                        $image['width']     = '240';
                        $image['height']    = '300';
                        $image['ratio']     = "1.25";
                        $image['label']     = $product->getName();
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
