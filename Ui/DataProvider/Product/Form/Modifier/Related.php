<?php

namespace Scaleflex\FileRobot\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Scaleflex\FileRobot\Model\FileRobotConfig;

class Related
{

    /** @var ProductRepositoryInterface  */
    protected $productRepository;

    /** @var FileRobotConfig  */
    protected $fileRobotConfig;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param FileRobotConfig $fileRobotConfig
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        FileRobotConfig $fileRobotConfig
    ) {
        $this->productRepository = $productRepository;
        $this->fileRobotConfig = $fileRobotConfig;
    }

    public function afterModifyData(
        \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related $subject,
        $result
    ) {
        foreach ($result as $key => $value) {
            if ($key !== 'config') {
                $links = $value['links'];
                foreach ($links as &$link) {
                   if (!empty($link)) {
                       foreach ($link as &$linked) {
                            $product = $this->productRepository->getById($linked['id']);
                            $images = $product->getMediaAttributeValues();
                            if (!empty($images) && $images['image'] && $this->fileRobotConfig->isFilerobot($images['image'])) {
                               $linked['thumbnail'] = $images['image'];
                            }
                       }
                   }
                }
                $result[$key]['links'] = $links;
            }
        }

        return $result;
    }
}
