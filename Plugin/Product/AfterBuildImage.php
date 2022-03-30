<?php

namespace Scaleflex\FileRobot\Plugin\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;

class AfterBuildImage
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    public function afterCreate(
        \Magento\Catalog\Block\Product\ImageBuilder $subject,
        $result
    ) {
       return $result;
    }
}
