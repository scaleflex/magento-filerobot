<?php

namespace Scaleflex\Filerobot\Plugin\Checkout;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class Image
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
     * @param $item
     * @param $result
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetImage($item, $result)
    {
        if ($result->getData('product_id')) {
            $productId = $result->getData('product_id');
            $product = $this->productRepository->getById($productId);
            $images = $product->getMediaAttributeValues();
            if (!empty($images) && $images['thumbnail'] && $this->fileRobotConfig->isFilerobot($images['thumbnail'])) {
                $result->setImageUrl($images['thumbnail']);
            }
        }
        return $result;
    }
}
