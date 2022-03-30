<?php

namespace Scaleflex\FileRobot\Plugin\Minicart;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\CustomerData\AbstractItem;

class AfterGetItemData
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function aroundGetItemData(
        \Magento\Checkout\CustomerData\AbstractItem $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Item $item
    ) {
        $data = $proceed($item);
        $product = $this->productRepository->getById($data['product_id']);
        $images = $product->getMediaAttributeValues();
        if (!empty($images) && $images['image'] && str_contains($images['image'], 'filerobot')) {
            $data['product_image']['src'] = $images['thumbnail'];
        }
        return $data;
    }
}
