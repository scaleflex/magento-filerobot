<?php

namespace Scaleflex\FileRobot\Plugin\Minicart;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\CustomerData\AbstractItem;
use Scaleflex\FileRobot\Model\FileRobotConfig;

class AfterGetItemData
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

    public function aroundGetItemData(
        \Magento\Checkout\CustomerData\AbstractItem $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Item $item
    ) {
        $data = $proceed($item);
        $product = $this->productRepository->getById($data['product_id']);
        $images = $product->getMediaAttributeValues();
        if (!empty($images) && $images['image'] && $this->fileRobotConfig->isFilerobot($images['image'])) {
            $data['product_image']['src'] = $images['thumbnail'];
        }
        return $data;
    }
}
