<?php

namespace Scaleflex\FileRobot\Plugin\Checkout;

use Magento\Catalog\Api\ProductRepositoryInterface;

class Image
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function afterGetImage($item, $result)
    {
        if ($result->getData('product_id')) {
            $productId = $result->getData('product_id');
            $product = $this->productRepository->getById($productId);
            $images = $product->getMediaAttributeValues();
            if (!empty($images) && $images['image'] && str_contains($images['image'], 'filerobot')) {
                $result->setImageUrl($images['thumbnail']);
            }
        }
        return $result;
    }
}
