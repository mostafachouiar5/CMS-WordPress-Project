import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';
import { s as speak } from './index-c5a96d53.js';
import { s as setDefaultAnimation, b as stopAnimations, g as getAnimation, a as animateTo, c as shimKeyframesHeightAuto } from './animation-registry-12eed2e3.js';

const scSummaryCss = ":host{display:block;font-family:var(--sc-font-sans);font-size:var(--sc-checkout-font-size, 16px)}.collapse-link{display:flex;align-items:center;gap:0.35em}.summary__content--empty{display:none}.collapse-link__icon{width:18px;height:18px;color:var(--sc-order-collapse-link-icon-color, var(--sc-color-gray-500))}.item__product+.item__product{margin-top:20px}.empty{color:var(--sc-order-summary-color, var(--sc-color-gray-500))}.price{display:inline-block;opacity:0;visibility:hidden;transform:translateY(5px);transition:var(--sc-input-transition, var(--sc-transition-medium)) visibility ease, var(--sc-input-transition, var(--sc-transition-medium)) opacity ease, var(--sc-input-transition, var(--sc-transition-medium)) transform ease}.price--collapsed{opacity:1;visibility:visible;transform:translateY(0)}.summary{position:relative;user-select:none;cursor:pointer}.summary .collapse-link__icon{transition:transform 0.25s ease-in-out}.summary .scratch-price{text-decoration:line-through;color:var(--sc-color-gray-500);font-size:var(--sc-font-size-small);margin-right:var(--sc-spacing-xx-small)}.summary--open .collapse-link__icon{transform:rotate(180deg)}::slotted(*){margin:4px 0 !important}::slotted(sc-divider){margin:16px 0 !important}sc-line-item~sc-line-item{margin-top:14px}.total-price{white-space:nowrap}";
const ScSummaryStyle0 = scSummaryCss;

const ScOrderSummary = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scShow = createEvent(this, "scShow", 7);
        this.scHide = createEvent(this, "scHide", 7);
        this.loading = undefined;
        this.busy = undefined;
        this.closedText = wp.i18n.__('Show Summary', 'surecart');
        this.openText = wp.i18n.__('Summary', 'surecart');
        this.collapsible = false;
        this.collapsedOnMobile = false;
        this.collapsedOnDesktop = undefined;
        this.collapsed = false;
    }
    isMobileScreen() {
        var _a, _b;
        const bodyRect = (_a = document.body) === null || _a === void 0 ? void 0 : _a.getClientRects();
        return (bodyRect === null || bodyRect === void 0 ? void 0 : bodyRect.length) && ((_b = bodyRect[0]) === null || _b === void 0 ? void 0 : _b.width) < 781;
    }
    componentWillLoad() {
        if (this.isMobileScreen()) {
            this.collapsed = this.collapsed || this.collapsedOnMobile;
        }
        else {
            this.collapsed = this.collapsed || this.collapsedOnDesktop;
        }
        this.handleOpenChange();
    }
    handleClick(e) {
        e.preventDefault();
        this.collapsed = !this.collapsed;
    }
    renderHeader() {
        // busy state
        if (this.loading) {
            return (h("sc-line-item", null, h("sc-skeleton", { slot: "title", style: { width: '120px', display: 'inline-block' } }), h("sc-skeleton", { slot: "price", style: { 'width': '70px', 'display': 'inline-block', '--border-radius': '6px' } }), h("sc-skeleton", { slot: "currency", style: { width: '30px', display: 'inline-block' } })));
        }
        return (h("sc-line-item", { style: { '--price-size': 'var(--sc-font-size-x-large)' } }, h("span", { class: "collapse-link", slot: "title", onClick: e => this.handleClick(e), tabIndex: 0, "aria-label": wp.i18n.sprintf(wp.i18n.__('Summary %s', 'surecart'), this.collapsed ? wp.i18n.__('collapsed', 'surecart') : wp.i18n.__('expanded', 'surecart')), onKeyDown: e => {
                if (e.key === ' ') {
                    this.handleClick(e);
                    speak(wp.i18n.sprintf(wp.i18n.__('Summary %s', 'surecart'), this.collapsed ? wp.i18n.__('collapsed', 'surecart') : wp.i18n.__('expanded', 'surecart')), 'assertive');
                }
            } }, this.collapsed ? this.closedText || wp.i18n.__('Summary', 'surecart') : this.openText || wp.i18n.__('Summary', 'surecart'), h("svg", { xmlns: "http://www.w3.org/2000/svg", class: "collapse-link__icon", fill: "none", viewBox: "0 0 24 24", stroke: "currentColor" }, h("path", { "stroke-linecap": "round", "stroke-linejoin": "round", "stroke-width": "2", d: "M19 9l-7 7-7-7" }))), h("span", { slot: "description" }, h("slot", { name: "description" })), h("span", { slot: "price", class: { 'price': true, 'price--collapsed': this.collapsed } }, h("slot", { name: "price" }))));
    }
    async handleOpenChange() {
        if (!this.collapsed) {
            this.scShow.emit();
            await stopAnimations(this.body);
            this.body.hidden = false;
            this.body.style.overflow = 'hidden';
            const { keyframes, options } = getAnimation(this.el, 'summary.show');
            await animateTo(this.body, shimKeyframesHeightAuto(keyframes, this.body.scrollHeight), options);
            this.body.style.height = 'auto';
            this.body.style.overflow = 'visible';
        }
        else {
            this.scHide.emit();
            await stopAnimations(this.body);
            this.body.style.overflow = 'hidden';
            const { keyframes, options } = getAnimation(this.el, 'summary.hide');
            await animateTo(this.body, shimKeyframesHeightAuto(keyframes, this.body.scrollHeight), options);
            this.body.hidden = true;
            this.body.style.height = 'auto';
            this.body.style.overflow = 'visible';
        }
    }
    render() {
        return (h("div", { key: '8918c561500c2a8b2c6bc59e3524ae6a76fb72e4', class: { 'summary': true, 'summary--open': !this.collapsed } }, this.collapsible && this.renderHeader(), h("div", { key: '7f34f645358bf7cf3c51bae80aeb8016c4949f7b', ref: el => (this.body = el), class: {
                summary__content: true,
            } }, h("slot", { key: '05309f7be8b163c70a8eb7040c65dd8fe25bdc69' }))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "collapsed": ["handleOpenChange"]
    }; }
};
setDefaultAnimation('summary.show', {
    keyframes: [
        { height: '0', opacity: '0' },
        { height: 'auto', opacity: '1' },
    ],
    options: { duration: 250, easing: 'ease' },
});
setDefaultAnimation('summary.hide', {
    keyframes: [
        { height: 'auto', opacity: '1' },
        { height: '0', opacity: '0' },
    ],
    options: { duration: 250, easing: 'ease' },
});
ScOrderSummary.style = ScSummaryStyle0;

export { ScOrderSummary as sc_summary };

//# sourceMappingURL=sc-summary.entry.js.map