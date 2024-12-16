import { r as registerInstance, h, a as getElement } from './index-745b6bec.js';

const scCcLogoCss = ":host{display:inline-block}.cc-logo{border-radius:var(--sc-cc-border-radius, 4px);line-height:0;overflow:hidden}";
const ScCcLogoStyle0 = scCcLogoCss;

const ScCcLogo = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.brand = undefined;
    }
    renderLogo() {
        if (['visa', 'mastercard', 'amex', 'discover', 'diners', 'jcb', 'unionpay'].includes(this.brand)) {
            return h("sc-icon", { name: this.brand, style: { '--height': '0.63em' } });
        }
        return h("sc-icon", { name: "creditcard", style: { '--height': '0.63em' } });
    }
    render() {
        return (h("div", { key: '0220bbc6b47b4d4613318297378db24bed6a2104', class: "cc-logo", part: "base" }, this.renderLogo()));
    }
};
ScCcLogo.style = ScCcLogoStyle0;

const scTooltipCss = ".tooltip{position:relative}.tooltip--has-width .tooltip-text{white-space:normal;min-width:var(--sc-tooltip-width);max-width:var(--sc-tooltip-width)}.tooltip-text{position:fixed;background:var(--sc-color-gray-900);border-radius:var(--sc-border-radius-small);padding:var(--sc-spacing-small);font-family:var(--sc-input-font-family);font-size:var(--sc-input-font-size-small);white-space:nowrap;line-height:1.2;color:var(--sc-color-white);z-index:99999}.tooltip-text:after{content:\"\";position:absolute;transform:translateX(-50%);top:calc(100% - 1px);left:50%;height:0;width:0;border:7px solid transparent;border-top-color:var(--sc-color-gray-900)}.tooltip--primary .tooltip-text{background:var(--sc-color-primary-500)}.tooltip--primary .tooltip-text:after{border-top-color:var(--sc-color-primary-500)}.tooltip--success .tooltip-text{background:var(--sc-color-success-500)}.tooltip--success .tooltip-text:after{border-top-color:var(--sc-color-success-500)}.tooltip--info .tooltip-text{background:var(--sc-color-info-500)}.tooltip--info .tooltip-text:after{border-top-color:var(--sc-color-info-500)}.tooltip--warning .tooltip-text{background:var(--sc-color-warning-500)}.tooltip--warning .tooltip-text:after{border-top-color:var(--sc-color-warning-500)}.tooltip--danger .tooltip-text{background:var(--sc-color-danger-500)}.tooltip--danger .tooltip-text:after{border-top-color:var(--sc-color-danger-500)}";
const ScTooltipStyle0 = scTooltipCss;

const ScTooltip = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.open = undefined;
        this.width = undefined;
        this.text = undefined;
        this.freeze = undefined;
        this.padding = 5;
        this.type = 'info';
        this.top = -10000;
        this.left = -10000;
    }
    componentDidLoad() {
        this.handleWindowScroll();
    }
    handleWindowScroll() {
        if (!this.open)
            return;
        if (!this.tooltip)
            return;
        var linkProps = this.tooltip.getBoundingClientRect();
        var tooltipProps = this.el.getBoundingClientRect();
        this.top = tooltipProps.top - (linkProps.height + this.padding);
        const min = Math.max(tooltipProps.left + tooltipProps.width / 2 - linkProps.width / 2 + this.padding, 0);
        this.left = Math.min(min, window.innerWidth - linkProps.width);
    }
    handleOpenChange() {
        setTimeout(() => this.handleWindowScroll(), 0);
    }
    handleBlur() {
        if (this.freeze)
            return;
        this.open = false;
    }
    handleClick() {
        if (this.freeze)
            return;
        this.open = true;
    }
    handleFocus() {
        if (this.freeze)
            return;
        this.open = true;
    }
    handleMouseOver() {
        if (this.freeze)
            return;
        this.open = true;
    }
    handleMouseOut() {
        if (this.freeze)
            return;
        this.open = false;
    }
    render() {
        if (!this.text) {
            return h("slot", null);
        }
        return (h("span", { part: "base", class: {
                'tooltip': true,
                // Types
                'tooltip--primary': this.type === 'primary',
                'tooltip--success': this.type === 'success',
                'tooltip--info': this.type === 'info',
                'tooltip--warning': this.type === 'warning',
                'tooltip--danger': this.type === 'danger',
                'tooltip--has-width': !!this.width,
            }, onClick: () => this.handleClick(), onBlur: () => this.handleBlur(), onFocus: () => this.handleFocus(), onMouseOver: () => this.handleMouseOver(), onMouseOut: () => this.handleMouseOut() }, h("slot", null), !!this.open && (h("div", { part: "text", ref: el => (this.tooltip = el), class: "tooltip-text", style: {
                top: `${this.top}px`,
                left: `${this.left}px`,
                ...(this.width ? { '--sc-tooltip-width': this.width } : {}),
            } }, this.text))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "open": ["handleOpenChange"]
    }; }
};
ScTooltip.style = ScTooltipStyle0;

export { ScCcLogo as sc_cc_logo, ScTooltip as sc_tooltip };

//# sourceMappingURL=sc-cc-logo_2.entry.js.map