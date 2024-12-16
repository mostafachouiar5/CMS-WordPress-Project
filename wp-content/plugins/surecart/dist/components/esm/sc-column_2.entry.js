import { r as registerInstance, h, H as Host } from './index-745b6bec.js';

const scColumnCss = ":host{display:block}::slotted(:not(.wp-block-spacer):not(:last-child):not(.is-empty):not(style)){margin-bottom:var(--sc-form-row-spacing, 0.75em)}::slotted(:not(.wp-block-spacer):not(:last-child):not(.is-empty):not(style):not(.is-layout-flex)){display:block}";
const ScColumnStyle0 = scColumnCss;

const ScColumn = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    render() {
        return (h(Host, { key: '4d2fbfccbbc7e61957bc56aff3390796b49cfb7a' }, h("slot", { key: 'b7955e331c730811c6787d5d99d1846ac39c4459' })));
    }
};
ScColumn.style = ScColumnStyle0;

const scColumnsCss = ".sc-columns{display:flex;box-sizing:border-box;gap:var(--sc-column-spacing, var(--sc-spacing-xxxx-large));margin-left:auto;margin-right:auto;width:100%;flex-wrap:wrap !important;align-items:initial !important;}@media (min-width: 782px){.sc-columns{flex-wrap:nowrap !important}}.sc-columns.are-vertically-aligned-top{align-items:flex-start}.sc-columns.are-vertically-aligned-center{align-items:center}.sc-columns.are-vertically-aligned-bottom{align-items:flex-end}@media (max-width: 781px){.sc-columns:not(.is-not-stacked-on-mobile).is-full-height>sc-column{padding:30px !important}}.sc-columns:not(.is-not-stacked-on-mobile)>sc-column{max-width:none}@media (max-width: 781px){.sc-columns:not(.is-not-stacked-on-mobile)>sc-column{flex-basis:100% !important}}@media (min-width: 782px){.sc-columns:not(.is-not-stacked-on-mobile)>sc-column{flex-basis:0;flex-grow:1}.sc-columns:not(.is-not-stacked-on-mobile)>sc-column[style*=flex-basis]{flex-grow:0}}.sc-columns.is-not-stacked-on-mobile{flex-wrap:nowrap !important}.sc-columns.is-not-stacked-on-mobile>sc-column{flex-basis:0;flex-grow:1}.sc-columns.is-not-stacked-on-mobile>sc-column[style*=flex-basis]{flex-grow:0}@media (min-width: 782px){.sc-columns.is-full-height{min-height:100vh !important}}@media (max-width: 782px){.sc-columns.is-reversed-on-mobile{flex-direction:column-reverse}}sc-column{flex-grow:1;min-width:0;word-break:break-word;overflow-wrap:break-word;}sc-column.is-vertically-aligned-top{align-self:flex-start}sc-column.is-vertically-aligned-center{align-self:center}sc-column.is-vertically-aligned-bottom{align-self:flex-end}sc-column.is-vertically-aligned-top,sc-column.is-vertically-aligned-center,sc-column.is-vertically-aligned-bottom{width:100%}@media (min-width: 782px){sc-column.is-layout-constrained>:where(:not(.alignleft):not(.alignright):not(.alignfull)){max-width:var(--sc-column-content-width) !important}sc-column.is-layout-constrained.is-horizontally-aligned-right>:where(:not(.alignleft):not(.alignright):not(.alignfull)){margin-left:auto !important;margin-right:0 !important}sc-column.is-layout-constrained.is-horizontally-aligned-left>:where(:not(.alignleft):not(.alignright):not(.alignfull)){margin-right:auto !important;margin-left:0 !important}}@media (min-width: 782px){sc-column.is-sticky{position:sticky !important;align-self:flex-start;top:0}}";
const ScColumnsStyle0 = scColumnsCss;

const ScColumns = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.verticalAlignment = undefined;
        this.isStackedOnMobile = undefined;
        this.isFullHeight = undefined;
        this.isReversedOnMobile = undefined;
    }
    render() {
        return (h(Host, { key: 'f9e55a7db6425902eeab231291705d7013014c4b', class: {
                'sc-columns': true,
                [`are-vertically-aligned-${this.verticalAlignment}`]: !!this.verticalAlignment,
                'is-not-stacked-on-mobile': !this.isStackedOnMobile,
                'is-full-height': !!this.isFullHeight,
                'is-reversed-on-mobile': !!this.isReversedOnMobile,
            } }, h("slot", { key: '7d64623aef40d8d7c7690dee112ecc52b9bc3020' })));
    }
};
ScColumns.style = ScColumnsStyle0;

export { ScColumn as sc_column, ScColumns as sc_columns };

//# sourceMappingURL=sc-column_2.entry.js.map