<?php

namespace Scaleflex\Filerobot\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\View\Gallery;
use Scaleflex\Filerobot\Helper\Filerobot;
use Scaleflex\Filerobot\Model\FilerobotConfig;
use Magento\Catalog\Helper\Image;

class AddImageToGallery
{
    /** @var FilerobotConfig  */
    protected $fileRobotConfig;

    /** @var ProductRepositoryInterface  */
    protected $productRepository;

    /** @var Image  */
    protected $imageHelper;

    /** @var Filerobot  */
    protected $filerobotHelper;

    /**
     * @param FilerobotConfig $fileRobotConfig
     */
    public function __construct(
        FilerobotConfig $fileRobotConfig,
        ProductRepositoryInterface $productRepository,
        Image $imageHelper,
        Filerobot $filerobotHelper
    ) {
        $this->fileRobotConfig = $fileRobotConfig;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->filerobotHelper = $filerobotHelper;
    }

    public function afterGetGalleryImages(Gallery $gallery, $images)
    {
        foreach ($images as $image) {
            if ($this->fileRobotConfig->isFilerobot($image->getData('file'))) {
                $url = $image->getData('file');
                $entityId = $image->getData('entity_id') ? $image->getData('entity_id') : $image->getData('row_id');
                $product  = $this->productRepository->getById($entityId);
                if ($product) {
                    $thumbImageSize = $this->imageHelper->init($product, 'product_thumbnail_image');
                    $baseImageSize = $this->imageHelper->init($product, 'product_base_image');
                    $url = $this->filerobotHelper->buildImageBySize($image->getData('file'), $baseImageSize->getWidth(), $baseImageSize->getHeight());
                    $thumbnailUrl = $this->filerobotHelper->buildImageBySize($image->getData('file'), $thumbImageSize->getWidth(), $thumbImageSize->getHeight());
                }

                $image->setData('url', $url);
                $image->setData('small_image_url', $thumbnailUrl);
                $image->setData('medium_image_url',$url);
                $image->setData('large_image_url', $url);
            }
        }
        return $images;
    }
}
