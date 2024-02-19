<?php

namespace Scaleflex\Filerobot\Plugin\Minicart;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\CustomerData\AbstractItem;
use Scaleflex\Filerobot\Helper\Filerobot;
use Scaleflex\Filerobot\Model\FilerobotConfig;
use Magento\Catalog\Helper\Image;

class AfterGetItemData
{
    /** @var ProductRepositoryInterface */
    protected ProductRepositoryInterface $productRepository;

    /** @var FilerobotConfig */
    protected FilerobotConfig $fileRobotConfig;

    /** @var Image */
    protected $imageHelper;

    /** @var Filerobot */
    protected $filerobotHelper;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param FilerobotConfig $fileRobotConfig
     * @param Image $imageHelper
     * @param Filerobot $filerobotHelper
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        FilerobotConfig            $fileRobotConfig,
        Image                      $imageHelper,
        Filerobot                  $filerobotHelper

    )
    {
        $this->fileRobotConfig = $fileRobotConfig;
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        $this->filerobotHelper = $filerobotHelper;
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
    )
    {
        $data = $proceed($item);
        $product = $this->productRepository->getById($data['product_id']);
        $thumbImageSize = $this->imageHelper->init($product, 'product_thumbnail_image');
        $images = $product->getMediaAttributeValues();
        if (!empty($images) && $images['thumbnail'] && $this->fileRobotConfig->isFilerobot($images['thumbnail'])) {
            $data['product_image']['src'] = $this->filerobotHelper->buildImageBySize($images['thumbnail'],
                $thumbImageSize->getWidth(),
                $thumbImageSize->getHeight());
        }
        return $data;
    }
}
