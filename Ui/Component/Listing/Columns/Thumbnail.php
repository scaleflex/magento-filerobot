<?php

namespace Scaleflex\Filerobot\Ui\Component\Listing\Columns;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Scaleflex\Filerobot\Model\FilerobotConfig;

/**
 * Class Thumbnail Image
 *
 * @api
 */
class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';

    /** @var \Magento\Catalog\Helper\Image */
    private $imageHelper;

    /** @var \Magento\Framework\UrlInterface */
    private $urlBuilder;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var FilerobotConfig */
    private $fileRobotConfig;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface                $context,
        UiComponentFactory              $uiComponentFactory,
        \Magento\Catalog\Helper\Image   $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        ProductRepositoryInterface      $productRepository,
        FilerobotConfig                 $fileRobotConfig,
        array                           $components = [],
        array                           $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        $this->productRepository = $productRepository;
        $this->fileRobotConfig = $fileRobotConfig;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        try {
            if (isset($dataSource['data']['items'])) {
                $fieldName = $this->getData('name');
                foreach ($dataSource['data']['items'] as & $item) {
                    $product = $this->productRepository->getById($item['entity_id']);
                    $images = $product->getMediaAttributeValues();
                    if (!empty($images) && $images['thumbnail'] && $this->fileRobotConfig->isFilerobot($images['thumbnail'])) {
                        $item[$fieldName . '_src'] = $images['thumbnail'];
                        $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $product->getName();
                        $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                            'catalog/product/edit',
                            ['id' => $product->getEntityId(), 'store' => $this->context->getRequestParam('store')]
                        );
                        $item[$fieldName . '_orig_src'] = $images['image'];
                    } else {
                        $imageHelper = $this->imageHelper->init($product, 'product_listing_thumbnail');
                        $item[$fieldName . '_src'] = $imageHelper->getUrl();
                        $item[$fieldName . '_alt'] = $this->getAlt($item) ?: $imageHelper->getLabel();
                        $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                            'catalog/product/edit',
                            ['id' => $product->getEntityId(), 'store' => $this->context->getRequestParam('store')]
                        );
                        $origImageHelper = $this->imageHelper->init($product, 'product_listing_thumbnail_preview');
                        $item[$fieldName . '_orig_src'] = $origImageHelper->getUrl();
                    }
                }
            }
        } catch (\Exception $e) {
            //
        }

        return $dataSource;

    }

    /**
     * Get Alt
     *
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return $row[$altField] ?? null;
    }
}
