## Main Functionalities

Filerobot is a scalable and performance-oriented Digital Asset Management platform with integrated image and video 
optimizers to store, organize, optimize and deliver your media assets such as images, videos, PDFs and many other 
brand assets fast all around the world to all device types.
The Filerobot Plugin is an extension which adds Asset Management to Magento Admin(Product Images, Tinymce 4 WYSWYG) 
and shows it on the Front-end(Product listing page, Product detail page, Minicart, Cart Page, Checkout Page).

###Warning
The plugin will make some change in Admin:
- Currently the plugin only supports Text Component in Page Builder, other components will be supported 
- in future versions.
- TinyMCE Image(Insert/Edit) Default function will be disabled, you can change the image size by 
scale(drag/drop function) or delete and add a new one with the size you like.
- Plugin will disabled the default upload function in Product Edit Page, instead 
every image's assets will be managed by Filerobot.
- The plugin works well with Magento Luma default theme, if you are on a different theme, please check the manual 
integration below to get the product images.

## Installation

\* = in production please use the `--keep-generated` option

### Zip file

- Unzip the zip file in `app/code/Scaleflex`
- Enable the module by running `php bin/magento module:enable Scaleflex_FileRobot`
- Apply database updates by running `php bin/magento setup:upgrade`
- Apply Static by running `php bin/magento setup:static-content:deploy`
- Flush the cache by running `php bin/magento cache:flush`

## Configuration
Once the steps listed above are completed enter your Filerobot token, security template into the 
Filerobot module configuration the Magento admin interface

- Filerobot Token: Your Filerobot token
- Security Template Identifier: Your security template ID
- Filerobot upload directory: Folder path to your asset, ie /magento

## Specifications
Once activated, the Filerobot module will replace images from the site with images managed by Filerobot(if the image 
served by Filerobot then it will come from default).

Some place will be overridden by Filerobot:
- Product listing(catalog/search) page
- Product detail page / gallery
- Minicart
- Checkout cart page
- Checkout page

## Manual integration in Magento templates
- Database table(for reference): catalog_product_entity_media_gallery
- Example code to get product image in your code Block

```injectablephp
            $imageType = ‘image’; //image, thumbnail, small
        	try {
            /** @var \Magento\Catalog\Api\ProductRepositoryInterface  $productRepositoty */
            $product = $this->productRepositoty->getById($productId);
 
            if ($product) {
                $images = $product->getMediaAttributeValues();
                /** @var \Scaleflex\Filerobot\Model\FilerobotConfig $filerobotConfig */
                if (!empty($images) && $images[$imageType] && $filerobotConfig->isFilerobot($images[$imageType])) {
                    return $images[$imageType];
                }
                // If not filerobot image type you can get default url like below
                if ($imageType === 'image') $imageType = 'base';
                return $this->imageHelper->init($product, 'product_' . $imageType . '_image')->getUrl();
            }
            return null
        } catch (\Exception $exception) {
            // Exception          
        }

```


If you have any issue with the modification your template files, feel free to contact our [support](https://www.scaleflex.com/en/contact-us).

## Reference
- [Filerobot DAM Document](https://docs.filerobot.com/go/filerobot-documentation/en/plugins-and-integrations/media-asset-widget-fmaw)
- [Filerobot Website](https://www.scaleflex.com/en/home)
