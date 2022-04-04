<?php

namespace Scaleflex\FileRobot\Plugin\Checkout;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Scaleflex\FileRobot\Model\FileRobotConfig;

class Image
{
    protected ProductRepositoryInterface $productRepository;

    protected FileRobotConfig $fileRobotConfig;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        FileRobotConfig $fileRobotConfig
    ) {
        $this->fileRobotConfig = $fileRobotConfig;
        $this->productRepository = $productRepository;
    }

    public function afterGetImage($item, $result)
    {
        if ($result->getData('product_id')) {
            $productId = $result->getData('product_id');
            $product = $this->productRepository->getById($productId);
            $images = $product->getMediaAttributeValues();
            if (!empty($images) && $images['image'] && $this->fileRobotConfig->isFilerobot($images['image'])) {
                $result->setImageUrl($images['thumbnail']);
            }
        }
        return $result;
    }
}
