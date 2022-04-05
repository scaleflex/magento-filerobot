<?php

namespace Scaleflex\Filerobot\Helper;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Scaleflex\Filerobot\Model\FilerobotConfig;
use Magento\Catalog\Helper\Image as ProductImageHelper;

class Filerobot
{
    /** @var ProductRepositoryInterface */
    protected $productRepositoty;

    /** @var FilerobotConfig */
    protected $filerobotConfig;

    /** @var ProductImageHelper */
    protected $imageHelper;

    /**
     * @param FilerobotConfig $filerobotConfig
     * @param ProductImageHelper $imageHelper
     */
    public function __construct(
        ProductFactory     $productRepository,
        FilerobotConfig    $filerobotConfig,
        ProductImageHelper $imageHelper
    )
    {
        $this->productRepositoty = $productRepository;
        $this->filerobotConfig = $filerobotConfig;
        $this->imageHelper = $imageHelper;
    }

    /**
     * @param $productId
     * @param string $imageType
     * @return string|null
     */
    public function getProductImageById($productId, string $imageType = 'image')
    {
        try {
            $product = $this->productRepositoty->getById($productId);

            if ($product) {
                $images = $product->getMediaAttributeValues();
                if (!empty($images) && $images[$imageType] && $this->filerobotConfig->isFilerobot($images[$imageType])) {
                    return $images[$imageType];
                }
                return $this->imageHelper->init($product, 'product_'.$imageType.'image')->getUrl();
            }
            return null;
        } catch (\Exception $exception) {
            return null;
        }
    }
}
