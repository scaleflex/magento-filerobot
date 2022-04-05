<?php

namespace Scaleflex\Filerobot\Plugin\Minicart;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\CustomerData\AbstractItem;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class AfterGetItemData
{
    /** @var ProductRepositoryInterface  */
    protected ProductRepositoryInterface $productRepository;

    /** @var FilerobotConfig  */
    protected FilerobotConfig $fileRobotConfig;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param FilerobotConfig $fileRobotConfig
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        FilerobotConfig $fileRobotConfig
    ) {
        $this->fileRobotConfig = $fileRobotConfig;
        $this->productRepository = $productRepository;
    }

    /**
     * @param AbstractItem $subject
     * @param \Closure $proceed
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return array|mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function aroundGetItemData(
        \Magento\Checkout\CustomerData\AbstractItem $subject,
        \Closure                                    $proceed,
        \Magento\Quote\Model\Quote\Item             $item
    ) {
        $data = $proceed($item);
        $product = $this->productRepository->getById($data['product_id']);
        $images = $product->getMediaAttributeValues();
        if (!empty($images) && $images['thumbnail'] && $this->fileRobotConfig->isFilerobot($images['thumbnail'])) {
            $data['product_image']['src'] = $images['thumbnail'];
        }
        return $data;
    }
}
