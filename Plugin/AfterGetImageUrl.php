<?php

namespace Scaleflex\Filerobot\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Scaleflex\Filerobot\Helper\Filerobot;
use Scaleflex\Filerobot\Model\FilerobotConfig;
use Magento\Catalog\Block\Product\Image;

class AfterGetImageUrl
{

    /**
     * @var FilerobotConfig
     */
    protected FilerobotConfig $fileRobotConfig;

    protected $productRepository;

    protected $filerobotHelper;


    protected $imageHelper;
    /**
     * @param FilerobotConfig $fileRobotConfig
     */
    public function __construct(
        FilerobotConfig $fileRobotConfig,
        ProductRepositoryInterface $productRepository,
        Filerobot $filerobotHelper,
        ImageHelper $imageHelper
    ) {
        $this->imageHelper = $imageHelper;
        $this->filerobotHelper = $filerobotHelper;
        $this->fileRobotConfig = $fileRobotConfig;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Image $image
     * @param $method
     * @return array|null
     */
    public function after__call(Image $image, $result, $method)
    {
        if ($method == 'getImageUrl' && $image->getProductId() > 0) {
            $product = $this->productRepository->getById($image->getProductId());
            if ($product) {
                $images = $product->getMediaAttributeValues();
                if (!empty($images) && $images['image']) {
                    if ($this->fileRobotConfig->isFilerobot($images['image'])) {
                        $imageSize = $this->imageHelper->init($product, 'product_base_image');
                        $result = $this->filerobotHelper->buildImageBySize($images['image'], $imageSize->getHeight(), $imageSize->getHeight());
                    }
                }
            }
        }
        return $result;
    }
}
