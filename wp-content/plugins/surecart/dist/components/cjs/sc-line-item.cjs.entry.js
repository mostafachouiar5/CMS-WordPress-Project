'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const pageAlign = require('./page-align-5a2ab493.js');

const scLineItemCss = ":host{display:block;--mobile-size:380px;--price-size:var(--sc-font-size-medium);line-height:var(--sc-line-height-dense)}.item{display:grid;align-items:center;grid-template-columns:auto 1fr 1fr}@media screen and (min-width: var(--mobile-size)){.item{flex-wrap:no-wrap}}.item__title{color:var(--sc-line-item-title-color)}.item__price{color:var(--sc-input-label-color)}.item__title,.item__price{font-size:var(--sc-font-size-medium);font-weight:var(--sc-font-weight-semibold)}.item__description,.item__price-description{font-size:var(--sc-font-size-small);line-height:var(--sc-line-height-dense);color:var(--sc-input-label-color)}::slotted([slot=price-description]){margin-top:var(--sc-line-item-text-margin, 5px);color:var(--sc-input-label-color);text-decoration:none}.item__end{flex:1;display:flex;align-items:center;justify-content:flex-end;flex-wrap:wrap;align-self:flex-end;width:100%;margin-top:20px}@media screen and (min-width: 280px){.item__end{width:auto;text-align:right;margin-left:20px;margin-top:0}.item--is-rtl .item__end{margin-left:0;margin-right:20px}.item__price-text{text-align:right;display:flex;flex-direction:column;align-items:flex-end}}.item__price-currency{font-size:var(--sc-font-size-small);color:var(--sc-input-label-color);text-transform:var(--sc-currency-transform, uppercase);margin-right:8px}.item__text{flex:1}.item__price-description{display:-webkit-box}::slotted([slot=image]){margin-right:20px;width:50px;height:50px;object-fit:cover;border-radius:4px;border:1px solid var(--sc-color-gray-200);display:block;box-shadow:var(--sc-input-box-shadow)}::slotted([slot=price-description]){display:inline-block;width:100%;line-height:1}.item__price-layout{font-size:var(--sc-font-size-x-large);font-weight:var(--sc-font-weight-semibold);display:flex;align-items:center}.item__price{font-size:var(--price-size)}.item_currency{font-weight:var(--sc-font-weight-normal);font-size:var(--sc-font-size-xx-small);color:var(--sc-input-label-color);margin-right:var(--sc-spacing-small);text-transform:var(--sc-currency-text-transform, uppercase)}.item--is-rtl.item__description,.item--is-rtl.item__price-description{text-align:right}.item--is-rtl .item__text{text-align:right}@media screen and (min-width: 280px){.item--is-rtl .item__end{width:auto;text-align:left;margin-left:0;margin-top:0}.item--is-rtl .item__price-text{text-align:left}}";
const ScLineItemStyle0 = scLineItemCss;

const ScLineItem = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.price = undefined;
        this.currency = undefined;
        this.hasImageSlot = undefined;
        this.hasTitleSlot = undefined;
        this.hasDescriptionSlot = undefined;
        this.hasPriceSlot = undefined;
        this.hasPriceDescriptionSlot = undefined;
        this.hasCurrencySlot = undefined;
    }
    componentWillLoad() {
        this.hasImageSlot = !!this.hostElement.querySelector('[slot="image"]');
        this.hasTitleSlot = !!this.hostElement.querySelector('[slot="title"]');
        this.hasDescriptionSlot = !!this.hostElement.querySelector('[slot="description"]');
        this.hasPriceSlot = !!this.hostElement.querySelector('[slot="price"]');
        this.hasPriceDescriptionSlot = !!this.hostElement.querySelector('[slot="price-description"]');
        this.hasCurrencySlot = !!this.hostElement.querySelector('[slot="currency"]');
    }
    render() {
        return (index.h("div", { key: '81fbd87e15174d0e85c97a92e55003d175a36a1f', part: "base", class: {
                'item': true,
                'item--has-image': this.hasImageSlot,
                'item--has-title': this.hasTitleSlot,
                'item--has-description': this.hasDescriptionSlot,
                'item--has-price': this.hasPriceSlot,
                'item--has-price-description': this.hasPriceDescriptionSlot,
                'item--has-price-currency': this.hasCurrencySlot,
                'item--is-rtl': pageAlign.isRtl(),
            } }, index.h("div", { key: 'b87d1cb75340a9c6bc50e41409652b9b074e6a33', class: "item__image", part: "image" }, index.h("slot", { key: '509f019750ddf01b906508b4f6c56daf6a115065', name: "image" })), index.h("div", { key: '4ab68f58591454a0d14406f8259dc31ac583885b', class: "item__text", part: "text" }, index.h("div", { key: '61f98363f424d785ff63c06374862c14df4c743d', class: "item__title", part: "title" }, index.h("slot", { key: '702a5ff5223a1ccc19e5d932eae5f8e28686cb70', name: "title" })), index.h("div", { key: '2343778a44d7af3de1ec74ea3a9bcd8795d9e102', class: "item__description", part: "description" }, index.h("slot", { key: '85643c53086ff4f89cdbf09b518615a5c005aec2', name: "description" }))), index.h("div", { key: '0e6e9dc872092228a2a59509c0ee811f6c785dc5', class: "item__end", part: "price" }, index.h("div", { key: '76847c2426d11eaf8209dc498a5015b6c53ca125', class: "item__price-currency", part: "currency" }, index.h("slot", { key: '2fbbfa520a9ba5e0a2b9d6ccdf7eb440e1f04b76', name: "currency" })), index.h("div", { key: '5c56e81138a766dba8b66109a487e8b056e0a5c0', class: "item__price-text", part: "price-text" }, index.h("div", { key: '113bba1653dab380f43104d8e064fb590d415f25', class: "item__price", part: "price" }, index.h("slot", { key: 'f0c644f4a2b01cc6b4f750d4cb9a0cfec095d7c4', name: "price" })), index.h("div", { key: '440b9e221c7dfb8a6b533f95617036ce28ae7b10', class: "item__price-description", part: "price-description" }, index.h("slot", { key: 'a81319dc1b6c80a9739b4207254a9f3b07acae25', name: "price-description" }))))));
    }
    get hostElement() { return index.getElement(this); }
};
ScLineItem.style = ScLineItemStyle0;

exports.sc_line_item = ScLineItem;

//# sourceMappingURL=sc-line-item.cjs.entry.js.map