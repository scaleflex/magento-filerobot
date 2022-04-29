define(['uiComponent'], function (Component) {
    'use strict';

    var imageData = window.checkoutConfig.imageData;

    return Component.extend({
        defaults: {
            template: 'Magento_Checkout/summary/item/details/thumbnail'
        },
        displayArea: 'before_details',
        imageData: imageData,
        quoteItemData: window.checkoutConfig.quoteItemData,

        /**
         * @param {Object} item
         * @return {Array}
         */
        getImageItem: function (item) {
            if (this.imageData[item['item_id']]) {
                return this.imageData[item['item_id']];
            }

            return [];
        },

        getQuoteItem: function (item) {
            const item_id = item['item_id'];
            return this.quoteItemData.find((quoteItem) => quoteItem['item_id'] === String(item_id));
        },

        /**
         * @param {Object} item
         * @return {null}
         */
        getSrc: function (item) {
            const quoteItem = this.getQuoteItem(item);
            if (quoteItem['product']['thumbnail'].includes('filerobot')) {
                return quoteItem?.product?.thumbnail;
            } else if (this.imageData[item['item_id']]) {
                return this.imageData[item['item_id']].src;
            }

            return null;
        },

        /**
         * @param {Object} item
         * @return {null}
         */
        getWidth: function (item) {
            if (this.imageData[item['item_id']]) {
                return this.imageData[item['item_id']].width;
            }

            return null;
        },

        /**
         * @param {Object} item
         * @return {null}
         */
        getHeight: function (item) {
            if (this.imageData[item['item_id']]) {
                return this.imageData[item['item_id']].height;
            }

            return null;
        },

        /**
         * @param {Object} item
         * @return {null}
         */
        getAlt: function (item) {
            if (this.imageData[item['item_id']]) {
                return this.imageData[item['item_id']].alt;
            }

            return null;
        }
    });
});
