import { r as registerInstance, h, a as getElement } from './index-745b6bec.js';
import { i as isRtl } from './page-align-0cdacf32.js';

const scStackedListCss = ":host{display:block;font-family:var(--sc-font-sans)}:slotted(*){margin:0}";
const ScStackedListStyle0 = scStackedListCss;

const ScStackedList = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    render() {
        return h("slot", { key: '87cf18e72463675f38244a003cc9ae83924eab9c' });
    }
};
ScStackedList.style = ScStackedListStyle0;

const scStackedListRowCss = ":host{display:block;--column-width-min:125px;position:relative}:host(:not(:last-child)){border-bottom:1px solid var(--sc-stacked-list-border-color, var(--sc-color-gray-200))}:host(:focus-within){z-index:2}.list-row{background:var(--sc-list-row-background-color, var(--sc-color-white));color:var(--sc-list-row-color, var(--sc-color-gray-800));text-decoration:none;display:grid;justify-content:var(--sc-stacked-list-row-justify-content, space-between);align-items:var(--sc-stacked-list-row-align-items, start);grid-template-columns:repeat(auto-fit, minmax(100%, 1fr));gap:var(--sc-spacing-xx-small);padding:var(--sc-spacing-medium) var(--sc-spacing-large);transition:background-color var(--sc-transition-fast) ease;border-radius:var(--sc-input-border-radius-medium);min-width:0px;min-height:0px}.list-row[href]:hover{background:var(--sc-stacked-list-row-hover-color, var(--sc-color-gray-50))}.list-row__prefix,.list-row__suffix{position:absolute;top:50%;transform:translateY(-50%);z-index:1}.list-row__prefix{left:var(--sc-spacing-large)}.list-row__suffix{right:var(--sc-spacing-large)}.list-row--has-prefix{padding-left:3.5em}.list-row--has-suffix{padding-right:3.5em;gap:var(--sc-spacing-xxxx-large)}.list-row.breakpoint-lg{grid-template-columns:repeat(calc(var(--columns) - 1), 1fr) 1fr;gap:var(--sc-spacing-large)}.list-row.breakpoint-lg ::slotted(:last-child:not(:first-child)){display:flex;justify-content:flex-end}.list-row--is-rtl.list-row__prefix,.list-row--is-rtl.list-row__suffix{left:20px;width:20px;transform:rotate(180deg)}.list-row--is-rtl.list-row__suffix{right:auto}.list-row--is-rtl.list-row--has-suffix{gap:var(--sc-spacing-large)}";
const ScStackedListRowStyle0 = scStackedListRowCss;

const ScStackedListRow = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.href = undefined;
        this.target = '_self';
        this.mobileSize = 600;
        this.width = undefined;
        this.hasPrefix = false;
        this.hasSuffix = false;
    }
    componentDidLoad() {
        // Only run if ResizeObserver is supported.
        if ('ResizeObserver' in window) {
            var ro = new window.ResizeObserver(entries => {
                entries.forEach(entry => {
                    this.width = entry.contentRect.width;
                });
            });
            ro.observe(this.el);
        }
    }
    handleSlotChange() {
        this.hasPrefix = !!Array.from(this.el.children).some(child => child.slot === 'prefix');
        this.hasSuffix = !!Array.from(this.el.children).some(child => child.slot === 'suffix');
    }
    render() {
        const Tag = this.href ? 'a' : 'div';
        return (h(Tag, { key: '4becab14ab5b662e4ea828f0b923139b623de325', href: this.href, target: this.target, part: "base", class: {
                'list-row': true,
                'list-row--has-prefix': this.hasPrefix,
                'list-row--has-suffix': this.hasSuffix,
                'breakpoint-lg': this.width >= this.mobileSize,
                'list-row--is-rtl': isRtl()
            } }, h("span", { key: '7174cff52f5631d12218ffed213cd2835bf066c8', class: "list-row__prefix" }, h("slot", { key: 'd65da13bc33ec52a14ce3318412f186e416da1e3', name: "prefix", onSlotchange: () => this.handleSlotChange() })), h("slot", { key: 'eeaa2e797f19efc158377ab18ea3be7f7d903787', onSlotchange: () => this.handleSlotChange() }), h("span", { key: 'ce5cedd563698a39f1401bb51e44681d6677f1a9', class: "list-row__suffix" }, h("slot", { key: '63d4e45ad9e9ad70e77378c2633405f3cd3cfa55', name: "suffix", onSlotchange: () => this.handleSlotChange() }))));
    }
    get el() { return getElement(this); }
};
ScStackedListRow.style = ScStackedListRowStyle0;

export { ScStackedList as sc_stacked_list, ScStackedListRow as sc_stacked_list_row };

//# sourceMappingURL=sc-stacked-list_2.entry.js.map