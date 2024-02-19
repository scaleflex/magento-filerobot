<?php

namespace Scaleflex\Filerobot\Plugin\Checkout;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Scaleflex\Filerobot\Helper\Filerobot;
use Scaleflex\Filerobot\Model\FilerobotConfig;
use Magento\Catalog\Helper\Image as ImageHelper;

class Image
{
    /** @var ProductRepositoryInterface */
    protected ProductRepositoryInterface $productRepository;

    /** @var FilerobotConfig */
    protected FilerobotConfig $fileRobotConfig;

    /** @var \Magento\Catalog\Helper\Image */
    protected $imageHelper;

    /** @var Filerobot */
    protected $filerobotHelper;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param FilerobotConfig $fileRobotConfig
     * @param ImageHelper $imageHelper
     * @param Filerobot $filerobotHelper
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        FilerobotConfig            $fileRobotConfig,
        ImageHelper                $imageHelper,
        Filerobot                  $filerobotHelper

    )
    {
        $this->fileRobotConfig = $fileRobotConfig;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->filerobotHelper = $filerobotHelper;
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
            $thumbImageSize = $this->imageHelper->init($product, 'product_thumbnail_image');
            $images = $product->getMediaAttributeValues();
            if (!empty($images) && $images['thumbnail'] && $this->fileRobotConfig->isFilerobot($images['thumbnail'])) {
                $result->setImageUrl($this->filerobotHelper->buildImageBySize($images['thumbnail'],
                    $thumbImageSize->getWidth(),
                    $thumbImageSize->getHeight()));
            }
        }
        return $result;
    }
}
