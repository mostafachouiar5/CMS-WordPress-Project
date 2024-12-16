'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const media = require('./media-43b85f3d.js');
const index$1 = require('./index-adacfa36.js');

const scProductItemImageCss = ":host{border-style:none}.product-img{max-width:100%;aspect-ratio:var(--sc-product-image-aspect-ratio);padding-top:var(--sc-product-image-padding-top, 0);padding-bottom:var(--sc-product-image-padding-bottom, 0);padding-left:var(--sc-product-image-padding-left, 0);padding-right:var(--sc-product-image-padding-right, 0);margin-top:var(--sc-product-image-margin-top, 0);margin-bottom:var(--sc-product-image-margin-bottom, 0);margin-left:var(--sc-product-image-margin-left, 0);margin-right:var(--sc-product-image-margin-right, 0);border:solid var(--sc-product-image-border-width) var(--sc-product-image-border-color);border-radius:var(--sc-product-image-border-radius);overflow:hidden}.product-img>img{width:100%;height:100%;box-sizing:border-box;object-fit:contain;display:block;transition:transform var(--sc-transition-medium) ease}.product-img.is_covered>img{object-fit:cover}.product-img.is_contained>img{object-fit:contain}.product-img_placeholder{width:100%;height:100%;background-color:var(--sc-color-gray-300)}.product-img:hover img{transform:scale(1.05)}";
const ScProductItemImageStyle0 = scProductItemImageCss;

const ScProductItemImage = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.product = undefined;
        this.sizing = undefined;
    }
    getSrc() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l;
        if ((_b = (_a = this.product) === null || _a === void 0 ? void 0 : _a.featured_product_media) === null || _b === void 0 ? void 0 : _b.url) {
            return (_d = (_c = this.product) === null || _c === void 0 ? void 0 : _c.featured_product_media) === null || _d === void 0 ? void 0 : _d.url;
        }
        if ((_g = (_f = (_e = this.product) === null || _e === void 0 ? void 0 : _e.featured_product_media) === null || _f === void 0 ? void 0 : _f.media) === null || _g === void 0 ? void 0 : _g.url) {
            return media.sizeImage((_k = (_j = (_h = this.product) === null || _h === void 0 ? void 0 : _h.featured_product_media) === null || _j === void 0 ? void 0 : _j.media) === null || _k === void 0 ? void 0 : _k.url, index$1.applyFilters('surecart/product-list/media/size', 900));
        }
        return `${(_l = window.scData) === null || _l === void 0 ? void 0 : _l.plugin_url}/images/placeholder.jpg`;
    }
    render() {
        const { alt, title } = media.getFeaturedProductMediaAttributes(this.product);
        return (index.h(index.Host, { key: '775c243aedfbb0c60ee3b52d1b4d40aab264b833', style: { borderStyle: 'none' } }, index.h("div", { key: '4c704759ca73f506555aa5a611ba1dc1ddd5aeb7', class: {
                'product-img': true,
                'is_contained': this.sizing === 'contain',
                'is_covered': this.sizing === 'cover',
            } }, !!this.getSrc() ? index.h("img", { src: this.getSrc(), alt: alt, ...(title ? { title } : {}) }) : index.h("div", { class: "product-img_placeholder" }))));
    }
};
ScProductItemImage.style = ScProductItemImageStyle0;

const scProductItemPriceCss = ":host{display:block;line-height:1}.product-price{padding-top:var(--sc-product-price-padding-top, 0);padding-bottom:var(--sc-product-price-padding-bottom, 0);padding-left:var(--sc-product-price-padding-left, 0);padding-right:var(--sc-product-price-padding-right, 0);margin-top:var(--sc-product-price-margin-top, 0);margin-bottom:var(--sc-product-price-margin-bottom, 0);margin-left:var(--sc-product-price-margin-left, 0);margin-right:var(--sc-product-price-margin-right, 0);text-align:var(--sc-product-price-align);font-size:var(--sc-product-price-font-size);font-weight:var(--sc-product-price-font-weight);color:var(--sc-product-price-text-color)}";
const ScProductItemPriceStyle0 = scProductItemPriceCss;

const ScProductItemPrice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.prices = undefined;
        this.range = true;
        this.metrics = undefined;
    }
    componentWillLoad() {
        var _a, _b, _c, _d, _e, _f;
        // If min-max price is different, then generate a price range.
        if (this.range && ((_a = this.metrics) === null || _a === void 0 ? void 0 : _a.min_price_amount) !== ((_b = this.metrics) === null || _b === void 0 ? void 0 : _b.max_price_amount)) {
            this.prices = [
                {
                    amount: (_c = this.metrics) === null || _c === void 0 ? void 0 : _c.min_price_amount,
                    currency: (_d = this.metrics) === null || _d === void 0 ? void 0 : _d.currency,
                },
                {
                    amount: (_e = this.metrics) === null || _e === void 0 ? void 0 : _e.max_price_amount,
                    currency: (_f = this.metrics) === null || _f === void 0 ? void 0 : _f.currency,
                },
            ];
        }
    }
    render() {
        var _a;
        const price = (this.prices || []).sort((a, b) => (a === null || a === void 0 ? void 0 : a.position) - (b === null || b === void 0 ? void 0 : b.position)).find(price => !(price === null || price === void 0 ? void 0 : price.archived));
        return (index.h("div", { key: '0a0c25c85be003208ae05d90861b813bb7eb140c', class: "product-price", part: "base" }, !this.range && ((_a = this.prices) === null || _a === void 0 ? void 0 : _a.length) ? (index.h("sc-format-number", { type: "currency", currency: (price === null || price === void 0 ? void 0 : price.currency) || 'usd', value: price === null || price === void 0 ? void 0 : price.amount })) : (index.h("sc-price-range", { prices: this.prices }))));
    }
};
ScProductItemPrice.style = ScProductItemPriceStyle0;

const scProductItemTitleCss = ".product-item-title{padding-top:var(--sc-product-title-padding-top, 0);padding-bottom:var(--sc-product-title-padding-bottom, 0);margin-top:var(--sc-product-title-margin-top, 0);margin-bottom:var(--sc-product-title-margin-bottom, 0);font-size:var(--sc-product-title-font-size);text-align:var(--sc-product-title-align);font-weight:var(--sc-product-title-font-weight);color:var(--sc-product-title-text-color);line-height:1.2}";
const ScProductItemTitleStyle0 = scProductItemTitleCss;

const ScProductItemTitle = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
    }
    render() {
        return (index.h(index.Host, { key: 'f4284ebdca4dbc6b7cbdd5f1bd3b53462992ded6' }, index.h("div", { key: 'da25e8ea0cee8a860ecc84caa8412449c4a49e55', class: {
                'product-item-title': true,
            } }, index.h("slot", { key: '69aea2dc4562e2d963eb083607bde273d404967a' }))));
    }
};
ScProductItemTitle.style = ScProductItemTitleStyle0;

exports.sc_product_item_image = ScProductItemImage;
exports.sc_product_item_price = ScProductItemPrice;
exports.sc_product_item_title = ScProductItemTitle;

//# sourceMappingURL=sc-product-item-image_3.cjs.entry.js.map