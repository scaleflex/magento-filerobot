<?php

namespace Scaleflex\Filerobot\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Scaleflex\Filerobot\Model\FilerobotConfig;

class Related
{

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var FilerobotConfig */
    protected $fileRobotConfig;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param FilerobotConfig $fileRobotConfig
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        FilerobotConfig $fileRobotConfig
    ) {
        $this->productRepository = $productRepository;
        $this->fileRobotConfig = $fileRobotConfig;
    }

    /**
     * @param \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related $subject
     * @param $result
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterModifyData(
        \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related $subject,
                                                                       $result
    ) {
        foreach ($result as $key => $value) {
            if ($key !== 'config') {
                if (array_key_exists('links', $value)) {
                    $links = $value['links'];
                    foreach ($links as &$link) {
                        if (!empty($link)) {
                            foreach ($link as &$linked) {
                                $product = $this->productRepository->getById($linked['id']);
                                $images = $product->getMediaAttributeValues();
                                if (!empty($images) && $images['thumbnail'] && $this->fileRobotConfig->isFilerobot($images['thumbnail'])) {
                                    $linked['thumbnail'] = $images['thumbnail'];
                                }
                            }
                        }
                    }
                    $result[$key]['links'] = $links;
                }
            }
        }

        return $result;
    }
}
