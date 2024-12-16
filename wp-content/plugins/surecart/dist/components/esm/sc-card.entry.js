import { r as registerInstance, h, a as getElement } from './index-745b6bec.js';

const scCardCss = ":host{display:block;--overflow:visible}.card{font-family:var(--sc-font-sans);overflow:var(--overflow);display:block}.card:not(.card--borderless){padding:var(--sc-card-padding, var(--sc-spacing-large));background:var(--sc-card-background-color, var(--sc-color-white));border:1px solid var(--sc-card-border-color, var(--sc-color-gray-300));border-radius:var(--sc-input-border-radius-medium);box-shadow:var(--sc-shadow-small)}.card:not(.card--borderless).card--no-padding{padding:0}.title--divider{display:none}.card--has-title-slot .card--title{font-weight:var(--sc-font-weight-bold);line-height:var(--sc-line-height-dense)}.card--has-title-slot .title--divider{display:block}::slotted(*){margin-bottom:var(--sc-form-row-spacing)}::slotted(*:first-child){margin-top:0}::slotted(*:last-child){margin-bottom:0 !important}";
const ScCardStyle0 = scCardCss;

const ScCard = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.noDivider = undefined;
        this.borderless = undefined;
        this.noPadding = undefined;
        this.href = undefined;
        this.loading = undefined;
        this.hasTitleSlot = undefined;
    }
    componentWillLoad() {
        this.handleSlotChange();
    }
    handleSlotChange() {
        this.hasTitleSlot = !!this.el.querySelector('[slot="title"]');
    }
    render() {
        const Tag = this.href ? 'a' : 'div';
        return (h(Tag, { key: 'b6fedccde48b021cb1a885ba1f5f9c65ab8aa4c7', part: "base", class: {
                'card': true,
                'card--borderless': this.borderless,
                'card--no-padding': this.noPadding,
            } }, h("slot", { key: 'f5f162eb19336a83446a1c9bd536cb835b0d8a9d' })));
    }
    get el() { return getElement(this); }
};
ScCard.style = ScCardStyle0;

export { ScCard as sc_card };

//# sourceMappingURL=sc-card.entry.js.map