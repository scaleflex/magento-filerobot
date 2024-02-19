<?php

namespace Scaleflex\Filerobot\Plugin\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;

class AfterBuildImage
{
    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Magento\Catalog\Block\Product\ImageBuilder $subject
     * @param $result
     * @return mixed
     */
    public function afterCreate(
        \Magento\Catalog\Block\Product\ImageBuilder $subject,
                                                    $result
    )
    {
        return $result;
    }
}
