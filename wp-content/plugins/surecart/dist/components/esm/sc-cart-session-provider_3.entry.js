import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';
import { u as updateFormState, s as state } from './mutations-d5e8faea.js';
import { d as updateCheckout } from './index-96490395.js';
import { c as createErrorNotice, s as state$1 } from './mutations-ed6d0770.js';
import { c as clearCheckout } from './mutations-01792dfb.js';
import { s as setDefaultAnimation, g as getAnimation, a as animateTo, b as stopAnimations } from './animation-registry-12eed2e3.js';
import { g as getAdditionalErrorMessages } from './getters-a7eec27c.js';
import './index-06061d4e.js';
import './utils-e9ee502a.js';
import './remove-query-args-938c53ea.js';
import './add-query-args-0e2a8393.js';
import './index-c5a96d53.js';
import './google-a86aa761.js';
import './currency-a0c9bff4.js';
import './store-7020541e.js';
import './price-d5770168.js';
import './fetch-2032d11d.js';

const ScCartSessionProvider = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scSetState = createEvent(this, "scSetState", 7);
    }
    handleUpdateSession(e) {
        const { data, options } = e.detail;
        if (options === null || options === void 0 ? void 0 : options.silent) {
            this.update(data);
        }
        else {
            this.loadUpdate(data);
        }
    }
    /** Handle the error response. */
    handleErrorResponse(e) {
        var _a, _b;
        if ((e === null || e === void 0 ? void 0 : e.code) === 'readonly' || ((_b = (_a = e === null || e === void 0 ? void 0 : e.additional_errors) === null || _a === void 0 ? void 0 : _a[0]) === null || _b === void 0 ? void 0 : _b.code) === 'checkout.customer.account_mismatch') {
            clearCheckout();
        }
        // expired
        if ((e === null || e === void 0 ? void 0 : e.code) === 'rest_cookie_invalid_nonce') {
            updateFormState('EXPIRE');
            return;
        }
        // something went wrong
        if (e === null || e === void 0 ? void 0 : e.message) {
            createErrorNotice(e);
        }
        // handle curl timeout errors.
        if ((e === null || e === void 0 ? void 0 : e.code) === 'http_request_failed') {
            createErrorNotice(wp.i18n.__('Something went wrong. Please reload the page and try again.', 'surecart'));
        }
    }
    /** Fetch a session. */
    async fetch(args = {}) {
        this.loadUpdate({ status: 'draft', ...args });
    }
    /** Update a the order */
    async update(data = {}, query = {}) {
        var _a;
        try {
            state.checkout = (await updateCheckout({
                id: (_a = state.checkout) === null || _a === void 0 ? void 0 : _a.id,
                data: {
                    ...data,
                },
                query: {
                    ...query,
                },
            }));
        }
        catch (e) {
            console.error(e);
            throw e;
        }
    }
    /** Updates a session with loading status changes. */
    async loadUpdate(data = {}) {
        try {
            updateFormState('FETCH');
            await this.update(data);
            updateFormState('RESOLVE');
        }
        catch (e) {
            updateFormState('REJECT');
            this.handleErrorResponse(e);
        }
    }
    render() {
        return (h("sc-line-items-provider", { key: 'a29f7c029f0d4d31e0954a562a8413f101ef127d', order: state.checkout, onScUpdateLineItems: e => this.loadUpdate({ line_items: e.detail }) }, h("slot", { key: '52312ff0130b58f3ede57e900dab062c7929200b' })));
    }
    get el() { return getElement(this); }
};

const scDrawerCss = ":host{display:contents}.drawer{top:0;left:0;width:100%;height:100%;pointer-events:none;overflow:hidden;font-family:var(--sc-font-sans);font-weight:var(--sc-font-weight-normal)}.drawer--contained{position:absolute;z-index:initial}.drawer--fixed{position:fixed;z-index:var(--sc-z-index-drawer)}.drawer__panel{position:absolute;display:flex;flex-direction:column;z-index:2;max-width:100%;max-height:100%;background-color:var(--sc-panel-background-color);box-shadow:var(--sc-shadow-x-large);transition:var(--sc-transition-medium) transform;overflow:auto;pointer-events:all}.drawer__panel:focus{outline:none}.drawer--top .drawer__panel{top:0;right:auto;bottom:auto;left:0;width:100%;height:var(--sc-drawer-size, 400px)}.drawer--end .drawer__panel{top:0;right:0;bottom:auto;left:auto;width:100%;max-width:var(--sc-drawer-size, 400px);height:100%}.drawer--bottom .drawer__panel{top:auto;right:auto;bottom:0;left:0;width:100%;height:var(--sc-drawer-size, 400px)}.drawer--start .drawer__panel{top:0;right:auto;bottom:auto;left:0;width:var(--sc-drawer-size, 400px);height:100%}.header__sticky{position:sticky;top:0;z-index:10;background:#fff}.drawer__header{display:flex;align-items:center;padding:var(--sc-drawer-header-spacing);border-bottom:var(--sc-drawer-border)}.drawer__title{flex:1 1 auto;font:inherit;font-size:var(--sc-font-size-large);line-height:var(--sc-line-height-dense);margin:0}.drawer__close{flex:0 0 auto;display:flex;align-items:center;font-size:var(--sc-font-size-x-large);color:var(--sc-color-gray-500);cursor:pointer}.drawer__body{flex:1 1 auto}.drawer--has-footer .drawer__footer{border-top:var(--sc-drawer-border);padding:var(--sc-drawer-footer-spacing)}.drawer__overlay{display:block;position:fixed;top:0;right:0;bottom:0;left:0;background-color:var(--sc-overlay-background-color);pointer-events:all}.drawer--contained .drawer__overlay{position:absolute}";
const ScDrawerStyle0 = scDrawerCss;

const ScDrawer = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scInitialFocus = createEvent(this, "scInitialFocus", 7);
        this.scRequestClose = createEvent(this, "scRequestClose", 7);
        this.scShow = createEvent(this, "scShow", 7);
        this.scHide = createEvent(this, "scHide", 7);
        this.scAfterShow = createEvent(this, "scAfterShow", 7);
        this.scAfterHide = createEvent(this, "scAfterHide", 7);
        this.open = false;
        this.label = '';
        this.placement = 'end';
        this.contained = false;
        this.noHeader = false;
        this.stickyHeader = false;
    }
    componentDidLoad() {
        this.drawer.hidden = !this.open;
        if (this.open && !this.contained) {
            this.lockBodyScrolling();
        }
        this.handleOpenChange();
    }
    disconnectedCallback() {
        this.unLockBodyScrolling();
    }
    lockBodyScrolling() {
        document.body.classList.add('sc-scroll-lock');
    }
    unLockBodyScrolling() {
        document.body.classList.remove('sc-scroll-lock');
    }
    /** Shows the drawer. */
    async show() {
        if (this.open) {
            return undefined;
        }
        this.open = true;
    }
    /** Hides the drawer */
    async hide() {
        if (!this.open) {
            return undefined;
        }
        this.open = false;
    }
    async requestClose(source = 'method') {
        const slRequestClose = this.scRequestClose.emit(source);
        if (slRequestClose.defaultPrevented) {
            const animation = getAnimation(this.el, 'drawer.denyClose');
            animateTo(this.panel, animation.keyframes, animation.options);
            return;
        }
        this.hide();
    }
    handleKeyDown(event) {
        if (event.key === 'Escape') {
            event.stopPropagation();
            this.requestClose('keyboard');
        }
    }
    async handleOpenChange() {
        if (this.open) {
            this.scShow.emit();
            this.originalTrigger = document.activeElement;
            // Lock body scrolling only if the drawer isn't contained
            if (!this.contained) {
                this.lockBodyScrolling();
            }
            // When the drawer is shown, Safari will attempt to set focus on whatever element has autofocus. This causes the
            // drawer's animation to jitter, so we'll temporarily remove the attribute, call `focus({ preventScroll: true })`
            // ourselves, and add the attribute back afterwards.
            //
            // Related: https://github.com/shoelace-style/shoelace/issues/693
            //
            const autoFocusTarget = this.el.querySelector('[autofocus]');
            if (autoFocusTarget) {
                autoFocusTarget.removeAttribute('autofocus');
            }
            await Promise.all([stopAnimations(this.drawer), stopAnimations(this.overlay)]);
            this.drawer.hidden = false;
            // Set initial focus
            requestAnimationFrame(() => {
                const slInitialFocus = this.scInitialFocus.emit();
                if (!slInitialFocus.defaultPrevented) {
                    // Set focus to the autofocus target and restore the attribute
                    if (autoFocusTarget) {
                        autoFocusTarget.focus({ preventScroll: true });
                    }
                    else {
                        this.panel.focus({ preventScroll: true });
                    }
                }
                // Restore the autofocus attribute
                if (autoFocusTarget) {
                    autoFocusTarget.setAttribute('autofocus', '');
                }
            });
            const panelAnimation = getAnimation(this.el, `drawer.show${this.placement.charAt(0).toUpperCase() + this.placement.slice(1)}`);
            const overlayAnimation = getAnimation(this.el, 'drawer.overlay.show');
            await Promise.all([animateTo(this.panel, panelAnimation.keyframes, panelAnimation.options), animateTo(this.overlay, overlayAnimation.keyframes, overlayAnimation.options)]);
            this.scAfterShow.emit();
        }
        else {
            // Hide
            this.scHide.emit();
            this.unLockBodyScrolling();
            await Promise.all([stopAnimations(this.drawer), stopAnimations(this.overlay)]);
            const panelAnimation = getAnimation(this.el, `drawer.hide${this.placement.charAt(0).toUpperCase() + this.placement.slice(1)}`);
            const overlayAnimation = getAnimation(this.el, 'drawer.overlay.hide');
            await Promise.all([animateTo(this.panel, panelAnimation.keyframes, panelAnimation.options), animateTo(this.overlay, overlayAnimation.keyframes, overlayAnimation.options)]);
            this.drawer.hidden = true;
            // Restore focus to the original trigger
            const trigger = this.originalTrigger;
            if (typeof (trigger === null || trigger === void 0 ? void 0 : trigger.focus) === 'function') {
                setTimeout(() => trigger.focus());
            }
            this.scAfterHide.emit();
        }
    }
    render() {
        return (h("div", { key: '993db774b89138d7bb1ad43a131feced95879375', part: "base", class: {
                'drawer': true,
                'drawer--open': this.open,
                'drawer--top': this.placement === 'top',
                'drawer--end': this.placement === 'end',
                'drawer--bottom': this.placement === 'bottom',
                'drawer--start': this.placement === 'start',
                'drawer--contained': this.contained,
                'drawer--fixed': !this.contained,
                'drawer--has-footer': this.el.querySelector('[slot="footer"]') !== null,
            }, ref: el => (this.drawer = el), onKeyDown: (e) => this.handleKeyDown(e) }, h("div", { key: 'c4f1e4caae6c3506742a8936274844f14245c61e', part: "overlay", class: "drawer__overlay", onClick: () => this.requestClose('overlay'), tabindex: "-1", ref: el => (this.overlay = el) }), h("div", { key: '959ee2cefae71c5d8c64f7e4ef7c30c19f05e061', part: "panel", class: "drawer__panel", role: "dialog", "aria-modal": "true", "aria-hidden": this.open ? 'false' : 'true', "aria-label": this.noHeader ? this.label : undefined, "aria-labelledby": !this.noHeader ? 'title' : undefined, tabindex: "0", ref: el => (this.panel = el) }, !this.noHeader && (h("header", { key: '9399131883a89301751ef8b98cc8cb1581ae57f4', part: "header", class: this.stickyHeader ? 'header__sticky' : '' }, h("slot", { key: 'd4fc246a98fe07d8daeaa1c2c3f9cb59d4b197c8', name: "header" }, h("div", { key: 'e7109cc2d22bf8382163b697365811774c4ad2a4', class: "drawer__header" }, h("h2", { key: '7411ac3941667f3b5463199f05bcf1c12fe42799', part: "title", class: "drawer__title", id: "title" }, h("slot", { key: '3a2fff42af1808bc3ffc2b7b8ebf72281dc25c19', name: "label" }, this.label.length > 0 ? this.label : ' ', " ")), h("sc-icon", { key: 'd46362405e1005c3cb4d187396fac53e96a9ba71', part: "close-button", exportparts: "base:close-button__base", class: "drawer__close", name: "x", label: 
            /** translators: Close this modal window. */
            wp.i18n.__('Close', 'surecart'), onClick: () => this.requestClose('close-button') }))))), h("footer", { key: '1913337a792b0e335b557d5830b249f6b54928ba', part: "header-suffix", class: "drawer__header-suffix" }, h("slot", { key: 'da1fd4783c396f3c994912caa2686aec11548486', name: "header-suffix" })), h("div", { key: '050b5d1fa70e4f89457e89e42755dcf07330a0b2', part: "body", class: "drawer__body" }, h("slot", { key: '7423d4af54ed7d0846a3e7903b69572b0a61cb5e' })), h("footer", { key: '46dc71ff5c263cdf9e9b27a134b313e493c79e39', part: "footer", class: "drawer__footer" }, h("slot", { key: '315b35f84c747979c9a344c93e31752371aa136d', name: "footer" })))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "open": ["handleOpenChange"]
    }; }
};
// Top
setDefaultAnimation('drawer.showTop', {
    keyframes: [
        { opacity: 0, transform: 'translateY(-100%)' },
        { opacity: 1, transform: 'translateY(0)' },
    ],
    options: { duration: 250, easing: 'ease' },
});
setDefaultAnimation('drawer.hideTop', {
    keyframes: [
        { opacity: 1, transform: 'translateY(0)' },
        { opacity: 0, transform: 'translateY(-100%)' },
    ],
    options: { duration: 250, easing: 'ease' },
});
// End
setDefaultAnimation('drawer.showEnd', {
    keyframes: [
        { opacity: 0, transform: 'translateX(100%)' },
        { opacity: 1, transform: 'translateX(0)' },
    ],
    options: { duration: 250, easing: 'ease' },
});
setDefaultAnimation('drawer.hideEnd', {
    keyframes: [
        { opacity: 1, transform: 'translateX(0)' },
        { opacity: 0, transform: 'translateX(100%)' },
    ],
    options: { duration: 250, easing: 'ease' },
});
// Bottom
setDefaultAnimation('drawer.showBottom', {
    keyframes: [
        { opacity: 0, transform: 'translateY(100%)' },
        { opacity: 1, transform: 'translateY(0)' },
    ],
    options: { duration: 250, easing: 'ease' },
});
setDefaultAnimation('drawer.hideBottom', {
    keyframes: [
        { opacity: 1, transform: 'translateY(0)' },
        { opacity: 0, transform: 'translateY(100%)' },
    ],
    options: { duration: 250, easing: 'ease' },
});
// Start
setDefaultAnimation('drawer.showStart', {
    keyframes: [
        { opacity: 0, transform: 'translateX(-100%)' },
        { opacity: 1, transform: 'translateX(0)' },
    ],
    options: { duration: 250, easing: 'ease' },
});
setDefaultAnimation('drawer.hideStart', {
    keyframes: [
        { opacity: 1, transform: 'translateX(0)' },
        { opacity: 0, transform: 'translateX(-100%)' },
    ],
    options: { duration: 250, easing: 'ease' },
});
// Deny close
setDefaultAnimation('drawer.denyClose', {
    keyframes: [{ transform: 'scale(1)' }, { transform: 'scale(1.01)' }, { transform: 'scale(1)' }],
    options: { duration: 250 },
});
// Overlay
setDefaultAnimation('drawer.overlay.show', {
    keyframes: [{ opacity: 0 }, { opacity: 1 }],
    options: { duration: 250, easing: 'ease' },
});
setDefaultAnimation('drawer.overlay.hide', {
    keyframes: [{ opacity: 1 }, { opacity: 0 }],
    options: { duration: 250, easing: 'ease' },
});
ScDrawer.style = ScDrawerStyle0;

const ScFormErrorProvider = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scUpdateError = createEvent(this, "scUpdateError", 7);
        this.error = undefined;
    }
    /** Trigger the error event when an error happens  */
    handleErrorUpdate(val) {
        this.scUpdateError.emit(val);
    }
    render() {
        return !!(state$1 === null || state$1 === void 0 ? void 0 : state$1.message) ? (h("sc-alert", { exportparts: "base, icon, text, title, message, close", type: "danger", scrollOnOpen: true, open: !!(state$1 === null || state$1 === void 0 ? void 0 : state$1.message), closable: !!(state$1 === null || state$1 === void 0 ? void 0 : state$1.dismissible) }, (state$1 === null || state$1 === void 0 ? void 0 : state$1.message) && h("span", { slot: "title", innerHTML: state$1.message }), (getAdditionalErrorMessages() || []).map((message, index) => (h("div", { innerHTML: message, key: index }))))) : null;
    }
    static get watchers() { return {
        "error": ["handleErrorUpdate"]
    }; }
};

export { ScCartSessionProvider as sc_cart_session_provider, ScDrawer as sc_drawer, ScFormErrorProvider as sc_error };

//# sourceMappingURL=sc-cart-session-provider_3.entry.js.map