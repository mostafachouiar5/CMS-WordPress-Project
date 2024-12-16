'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-f25a0cb0.js');
const price = require('./price-653ec1cb.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
const formData = require('./form-data-0da9940f.js');
require('./remove-query-args-b57e8cd3.js');
require('./currency-71fce0f0.js');

/**
 * Replace the {{ name }} in a string with a new value
 */
const replaceAmount = (string, replace, name = 'amount') => {
    return string.replaceAll('{{' + name + '}}', replace).replaceAll('{{ ' + name + ' }}', replace);
};
/**
 * Replace the amount in a string with discount.
 */
const replaceAmountFromString = (amountStr, protocol) => (protocol === null || protocol === void 0 ? void 0 : protocol.preservation_coupon) ? replaceAmount(amountStr, price.getHumanDiscount(protocol === null || protocol === void 0 ? void 0 : protocol.preservation_coupon)) : amountStr;
/**
 *
 */
const getCurrentBehaviourContent = (protocol, hasDiscount) => {
    const { preserve_title, preserve_description, preserve_button, cancel_link } = (protocol === null || protocol === void 0 ? void 0 : protocol.preservation_locales) || {};
    if (hasDiscount) {
        const discountLocales = {
            title: replaceAmountFromString(wp.i18n.__('Your {{ amount }} discount is still active.', 'surecart'), protocol),
            description: replaceAmountFromString(wp.i18n.__('You have a {{ amount }} discount active. Cancelling now will forfeit this discount forever. Are you sure you wish to cancel?', 'surecart'), protocol),
            button: wp.i18n.__('Keep My Discount', 'surecart'),
            cancel_link: wp.i18n.__('Cancel Anyway', 'surecart'),
        };
        return discountLocales;
    }
    const defaultLocales = {
        title: replaceAmountFromString(preserve_title, protocol),
        description: replaceAmountFromString(preserve_description, protocol),
        button: preserve_button,
        cancel_link: cancel_link,
    };
    return defaultLocales;
};

const scCancelDiscountCss = ".cancel-discount__abort-link{color:var(--sc-color-gray-500)}";
const ScCancelDiscountStyle0 = scCancelDiscountCss;

const ScCancelDiscount = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scCancel = index.createEvent(this, "scCancel", 7);
        this.scPreserved = index.createEvent(this, "scPreserved", 7);
        this.subscription = undefined;
        this.reason = undefined;
        this.comment = undefined;
        this.protocol = undefined;
        this.loading = undefined;
        this.error = undefined;
    }
    async addDiscount() {
        var _a, _b;
        try {
            this.loading = true;
            this.subscription = (await fetch.apiFetch({
                method: 'PATCH',
                path: addQueryArgs.addQueryArgs(`surecart/v1/subscriptions/${(_a = this.subscription) === null || _a === void 0 ? void 0 : _a.id}/preserve`, {
                    cancellation_act: {
                        ...(!!this.comment ? { comment: this.comment } : {}),
                        cancellation_reason_id: (_b = this.reason) === null || _b === void 0 ? void 0 : _b.id,
                    },
                }),
            }));
            this.scPreserved.emit();
        }
        catch (e) {
            console.error(e);
            this.error = e;
        }
        finally {
            this.loading = false;
        }
    }
    hasDiscount() {
        var _a, _b;
        return !!((_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.discount) === null || _b === void 0 ? void 0 : _b.id);
    }
    render() {
        var _a, _b;
        const { title, description, button, cancel_link } = getCurrentBehaviourContent(this.protocol, (_b = (_a = this.subscription) === null || _a === void 0 ? void 0 : _a.discount) === null || _b === void 0 ? void 0 : _b.id);
        return (index.h("div", { key: '1e3234f5a046311223b48a1a351c291dc9ee77c8', class: "cancel-discount" }, index.h("sc-dashboard-module", { key: '13449ca7bcaf3d624555ca8d54f0940bda47ada3', heading: title, style: { '--sc-dashboard-module-spacing': '2em' } }, index.h("span", { key: 'a4c0441dc4903c9c14fcb9661b366b2db88706a7', slot: "description" }, description), index.h("sc-flex", { key: 'caa60edc75a785cc6f24ab28b5c40cceadca4706', justifyContent: "flex-start" }, index.h("sc-button", { key: '1ac401b834877bcdb619f25e6226307ee92e8675', type: "primary", onClick: () => this.addDiscount() }, button), index.h("sc-button", { key: '7c0c71eefe09175d2c0011eee0033fdeea5cb324', class: "cancel-discount__abort-link", type: "text", onClick: () => this.scCancel.emit() }, cancel_link)), !!this.loading && index.h("sc-block-ui", { key: 'a563ff82d602516fb014e04d24fba9e07b054457', spinner: true }))));
    }
};
ScCancelDiscount.style = ScCancelDiscountStyle0;

const scCancelSurveyCss = ".cancel-survey{color:var(--sc-color-gray-900)}.cancel-survey__abort-link{color:var(--sc-color-gray-500)}";
const ScCancelSurveyStyle0 = scCancelSurveyCss;

const ScCancelSurvey = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scAbandon = index.createEvent(this, "scAbandon", 7);
        this.scSubmitReason = index.createEvent(this, "scSubmitReason", 7);
        this.protocol = undefined;
        this.reasons = undefined;
        this.loading = undefined;
        this.selectedReason = undefined;
        this.comment = undefined;
        this.error = undefined;
    }
    componentWillLoad() {
        if (!this.reasons) {
            this.fetchReasons();
        }
    }
    handleSelectedReasonChange() {
        var _a;
        if ((_a = this.selectedReason) === null || _a === void 0 ? void 0 : _a.comment_enabled) {
            setTimeout(() => {
                this.textArea.triggerFocus();
            }, 50);
        }
    }
    async fetchReasons() {
        try {
            this.loading = true;
            this.reasons = await fetch.apiFetch({
                path: 'surecart/v1/cancellation_reasons',
            });
        }
        catch (e) {
            console.error(e);
            this.error = e;
        }
        finally {
            this.loading = false;
        }
    }
    async handleSubmit(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        try {
            this.scSubmitReason.emit({ reason: this.selectedReason, comment: this.comment });
        }
        catch (e) {
            console.error(e);
            this.error = e;
        }
    }
    renderReasons() {
        if (this.loading) {
            return (index.h("sc-choice", null, index.h("sc-skeleton", null)));
        }
        return (this.reasons || []).map(reason => (index.h("sc-choice", { value: reason === null || reason === void 0 ? void 0 : reason.id, name: "reason", onScChange: e => {
                if (e.target.checked) {
                    this.selectedReason = reason;
                }
            } }, reason === null || reason === void 0 ? void 0 : reason.label)));
    }
    render() {
        var _a, _b, _c;
        const { reasons_title, reasons_description, skip_link } = ((_a = this.protocol) === null || _a === void 0 ? void 0 : _a.preservation_locales) || {};
        if (this.loading) {
            return index.h("sc-skeleton", null);
        }
        return (index.h("div", { class: "cancel-survey" }, index.h("sc-dashboard-module", { heading: reasons_title, style: { '--sc-dashboard-module-spacing': '2em' } }, index.h("span", { slot: "description" }, reasons_description), index.h("sc-form", { onScSubmit: e => this.handleSubmit(e), style: { '--sc-form-row-spacing': '2em' } }, index.h("sc-choices", { showLabel: false, label: wp.i18n.__('Choose a reason', 'surecart'), style: { '--columns': '2' }, required: true }, this.renderReasons()), ((_b = this.selectedReason) === null || _b === void 0 ? void 0 : _b.comment_enabled) && (index.h("sc-textarea", { label: ((_c = this.selectedReason) === null || _c === void 0 ? void 0 : _c.comment_prompt) || wp.i18n.__('Additional Comments', 'surecart'), required: true, ref: el => (this.textArea = el), onScInput: e => (this.comment = e.target.value) })), index.h("sc-flex", { justifyContent: "flex-start" }, index.h("sc-button", { type: "primary", submit: true }, wp.i18n.__('Continue', 'surecart'), index.h("sc-icon", { name: "arrow-right", slot: "suffix" })), !!skip_link && (index.h("sc-button", { class: "cancel-survey__abort-link", type: "text", onClick: () => this.scAbandon.emit() }, skip_link)))))));
    }
    static get watchers() { return {
        "selectedReason": ["handleSelectedReasonChange"]
    }; }
};
ScCancelSurvey.style = ScCancelSurveyStyle0;

const scSubscriptionCancelCss = ":host{display:block;position:relative}.subscription-cancel{display:grid;gap:0.5em}.subscription-cancel__terms{color:var(--sc-color-gray-600);font-size:var(--sc-font-size-small)}";
const ScSubscriptionCancelStyle0 = scSubscriptionCancelCss;

const ScSubscriptionCancel = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scAbandon = index.createEvent(this, "scAbandon", 7);
        this.scCancelled = index.createEvent(this, "scCancelled", 7);
        this.heading = undefined;
        this.backUrl = undefined;
        this.successUrl = undefined;
        this.subscription = undefined;
        this.protocol = undefined;
        this.reason = undefined;
        this.comment = undefined;
        this.loading = undefined;
        this.busy = undefined;
        this.error = undefined;
    }
    async cancelSubscription() {
        var _a, _b;
        try {
            this.error = '';
            this.busy = true;
            await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`/surecart/v1/subscriptions/${(_a = this.subscription) === null || _a === void 0 ? void 0 : _a.id}/cancel`, {
                    cancellation_act: {
                        ...(!!this.comment ? { comment: this.comment } : {}),
                        cancellation_reason_id: (_b = this.reason) === null || _b === void 0 ? void 0 : _b.id,
                    },
                }),
                method: 'PATCH',
            });
            this.scCancelled.emit();
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            this.busy = false;
        }
    }
    renderContent() {
        var _a, _b;
        if (this.loading) {
            return this.renderLoading();
        }
        return (index.h(index.Fragment, null, ((_a = this === null || this === void 0 ? void 0 : this.protocol) === null || _a === void 0 ? void 0 : _a.cancel_behavior) === 'pending' ? (index.h("div", { slot: "description" }, wp.i18n.__('Your plan will be canceled, but is still available until the end of your billing period on', 'surecart'), ' ', index.h("strong", null, index.h("sc-format-date", { type: "timestamp", date: (_b = this === null || this === void 0 ? void 0 : this.subscription) === null || _b === void 0 ? void 0 : _b.current_period_end_at, month: "long", day: "numeric", year: "numeric" })), ". ", wp.i18n.__('If you change your mind, you can renew your subscription.', 'surecart'))) : (index.h("div", { slot: "description" }, wp.i18n.__('Your plan will be canceled immediately and cannot be modified later.', 'surecart')))));
    }
    renderLoading() {
        return (index.h("div", { style: { padding: '0.5em' } }, index.h("sc-skeleton", { style: { width: '30%', marginBottom: '0.75em' } }), index.h("sc-skeleton", { style: { width: '20%', marginBottom: '0.75em' } }), index.h("sc-skeleton", { style: { width: '40%' } })));
    }
    render() {
        return (index.h("sc-dashboard-module", { key: '7ecc2ac3d8167387891f3e4174258e66a142df38', heading: this.heading || wp.i18n.__('Cancel your plan', 'surecart'), class: "subscription-cancel", error: this.error, style: { '--sc-dashboard-module-spacing': '1em' } }, this.renderContent(), index.h("sc-flex", { key: 'ba36f3ee98d08b7d0678386056c579d9fcb36c9b', justifyContent: "flex-start" }, index.h("sc-button", { key: '4ea27387f4c6984fe6f91fefe355f575b31c9fb9', type: "primary", loading: this.loading || this.busy, disabled: this.loading || this.busy, onClick: () => this.cancelSubscription() }, wp.i18n.__('Cancel Plan', 'surecart')), index.h("sc-button", { key: '1eb6efffea221b5c339f867e8185f62274e2e563', style: { color: 'var(--sc-color-gray-500' }, type: "text", onClick: () => this.scAbandon.emit(), loading: this.loading || this.busy, disabled: this.loading || this.busy }, wp.i18n.__('Keep My Plan', 'surecart'))), this.busy && index.h("sc-block-ui", { key: 'a692166e215c820be2e09698266f62684d0a02fa' })));
    }
};
ScSubscriptionCancel.style = ScSubscriptionCancelStyle0;

const scTextareaCss = ":host{display:block}.textarea{display:flex;align-items:center;position:relative;width:100%;font-family:var(--sc-input-font-family);font-weight:var(--sc-input-font-weight);line-height:var(--sc-line-height-normal);letter-spacing:var(--sc-input-letter-spacing);vertical-align:middle;transition:var(--sc-input-transition, var(--sc-transition-medium)) color, var(--sc-input-transition, var(--sc-transition-medium)) border, var(--sc-input-transition, var(--sc-transition-medium)) box-shadow,\n    var(--sc-input-transition, var(--sc-transition-medium)) background-color;cursor:text}.textarea--standard{background-color:var(--sc-input-background-color);border:solid var(--sc-input-border-width) var(--sc-input-border-color)}.textarea--standard:hover:not(.textarea--disabled){background-color:var(--sc-input-background-color-hover);border-color:var(--sc-input-border-color-hover)}.textarea--standard:hover:not(.textarea--disabled) .textarea__control{color:var(--sc-input-color-hover)}.textarea--standard.textarea--focused:not(.textarea--disabled){background-color:var(--sc-input-background-color-focus);border-color:var(--sc-input-border-color-focus);color:var(--sc-input-color-focus);box-shadow:0 0 0 var(--sc-focus-ring-width) var(--sc-input-focus-ring-color)}.textarea--standard.textarea--focused:not(.textarea--disabled) .textarea__control{color:var(--sc-input-color-focus)}.textarea--standard.textarea--disabled{background-color:var(--sc-input-background-color-disabled);border-color:var(--sc-input-border-color-disabled);opacity:0.5;cursor:not-allowed}.textarea--standard.textarea--disabled .textarea__control{color:var(--sc-input-color-disabled)}.textarea--standard.textarea--disabled .textarea__control::placeholder{color:var(--sc-input-placeholder-color-disabled)}.textarea--filled{border:none;background-color:var(--sc-input-filled-background-color);color:var(--sc-input-color)}.textarea--filled:hover:not(.textarea--disabled){background-color:var(--sc-input-filled-background-color-hover)}.textarea--filled.textarea--focused:not(.textarea--disabled){background-color:var(--sc-input-filled-background-color-focus);outline:var(--sc-focus-ring);outline-offset:var(--sc-focus-ring-offset)}.textarea--filled.textarea--disabled{background-color:var(--sc-input-filled-background-color-disabled);opacity:0.5;cursor:not-allowed}.textarea__control{flex:1 1 auto;font-family:inherit;font-size:inherit;font-weight:inherit;line-height:1.4;color:var(--sc-input-color);border:none;background:none;box-shadow:none;cursor:inherit;-webkit-appearance:none}.textarea__control::-webkit-search-decoration,.textarea__control::-webkit-search-cancel-button,.textarea__control::-webkit-search-results-button,.textarea__control::-webkit-search-results-decoration{-webkit-appearance:none}.textarea__control::placeholder{color:var(--sc-input-placeholder-color);user-select:none}.textarea__control:focus{outline:none}.textarea--small{border-radius:var(--sc-input-border-radius-small);font-size:var(--sc-input-font-size-small)}.textarea--small .textarea__control{padding:0.5em var(--sc-input-spacing-small)}.textarea--medium{border-radius:var(--sc-input-border-radius-medium);font-size:var(--sc-input-font-size-medium)}.textarea--medium .textarea__control{padding:0.5em var(--sc-input-spacing-medium)}.textarea--large{border-radius:var(--sc-input-border-radius-large);font-size:var(--sc-input-font-size-large)}.textarea--large .textarea__control{padding:0.5em var(--sc-input-spacing-large)}.textarea--resize-none .textarea__control{resize:none}.textarea--resize-vertical .textarea__control{resize:vertical}.textarea--resize-auto .textarea__control{height:auto;resize:none}.textarea__char-limit-warning{margin-top:var(--sc-input-spacing-small);color:var(--sc-input-help-text-color);font-size:var(--sc-input-help-text-font-size-medium)}";
const ScTextareaStyle0 = scTextareaCss;

const CHAR_LIMIT_THRESHOLD = 20;
let id = 0;
const ScTextarea = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scChange = index.createEvent(this, "scChange", 7);
        this.scInput = index.createEvent(this, "scInput", 7);
        this.scBlur = index.createEvent(this, "scBlur", 7);
        this.scFocus = index.createEvent(this, "scFocus", 7);
        this.inputId = `textarea-${++id}`;
        this.helpId = `textarea-help-text-${id}`;
        this.labelId = `textarea-label-${id}`;
        this.hasFocus = false;
        this.showCharLimit = false;
        this.size = 'medium';
        this.name = undefined;
        this.value = '';
        this.filled = false;
        this.label = '';
        this.showLabel = true;
        this.help = '';
        this.placeholder = undefined;
        this.rows = 4;
        this.resize = 'vertical';
        this.disabled = false;
        this.readonly = false;
        this.minlength = undefined;
        this.maxlength = undefined;
        this.required = false;
        this.invalid = false;
        this.autocapitalize = undefined;
        this.autocorrect = undefined;
        this.autocomplete = undefined;
        this.autofocus = undefined;
        this.enterkeyhint = undefined;
        this.spellcheck = undefined;
        this.inputmode = undefined;
    }
    handleRowsChange() {
        this.setTextareaHeight();
    }
    handleValueChange() {
        this.invalid = !this.input.checkValidity();
        this.showCharLimit = this.maxlength - this.value.length <= CHAR_LIMIT_THRESHOLD;
    }
    handleDisabledChange() {
        // Disabled form controls are always valid, so we need to recheck validity when the state changes
        this.input.disabled = this.disabled;
        this.invalid = !this.input.checkValidity();
    }
    /** Sets focus on the input. */
    async triggerFocus(options) {
        return this.input.focus(options);
    }
    /** Sets focus on the textarea. */
    focus(options) {
        this.input.focus(options);
    }
    /** Removes focus from the textarea. */
    blur() {
        this.input.blur();
    }
    /** Selects all the text in the textarea. */
    select() {
        this.input.select();
    }
    /** Gets or sets the textarea's scroll position. */
    scrollPosition(position) {
        if (position) {
            if (typeof position.top === 'number')
                this.input.scrollTop = position.top;
            if (typeof position.left === 'number')
                this.input.scrollLeft = position.left;
            return;
        }
        // eslint-disable-next-line consistent-return
        return {
            top: this.input.scrollTop,
            left: this.input.scrollTop,
        };
    }
    /** Sets the start and end positions of the text selection (0-based). */
    setSelectionRange(selectionStart, selectionEnd, selectionDirection = 'none') {
        this.input.setSelectionRange(selectionStart, selectionEnd, selectionDirection);
    }
    /** Replaces a range of text with a new string. */
    setRangeText(replacement, start, end, selectMode = 'preserve') {
        this.input.setRangeText(replacement, start, end, selectMode);
        if (this.value !== this.input.value) {
            this.value = this.input.value;
            this.scInput.emit();
        }
        if (this.value !== this.input.value) {
            this.value = this.input.value;
            this.setTextareaHeight();
            this.scInput.emit();
            this.scChange.emit();
        }
    }
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    async reportValidity() {
        return this.input.reportValidity();
    }
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    setCustomValidity(message) {
        this.input.setCustomValidity(message);
        this.invalid = !this.input.checkValidity();
    }
    handleBlur() {
        this.hasFocus = false;
        this.scBlur.emit();
    }
    handleChange() {
        this.value = this.input.value;
        this.setTextareaHeight();
        this.scChange.emit();
    }
    handleFocus() {
        this.hasFocus = true;
        this.scFocus.emit();
    }
    handleInput() {
        this.value = this.input.value;
        this.setTextareaHeight();
        this.scInput.emit();
    }
    componentWillLoad() {
        if (!(window === null || window === void 0 ? void 0 : window.ResizeObserver)) {
            return;
        }
        this.resizeObserver = new window.ResizeObserver(() => this.setTextareaHeight());
    }
    componentDidLoad() {
        this.formController = new formData.FormSubmitController(this.el).addFormData();
        if (!(window === null || window === void 0 ? void 0 : window.ResizeObserver)) {
            return;
        }
        this.resizeObserver.observe(this.input);
    }
    disconnectedCallback() {
        var _a;
        (_a = this.formController) === null || _a === void 0 ? void 0 : _a.removeFormData();
        this.resizeObserver.unobserve(this.input);
    }
    setTextareaHeight() {
        if (this.resize === 'auto') {
            this.input.style.height = 'auto';
            this.input.style.height = `${this.input.scrollHeight}px`;
        }
        else {
            this.input.style.height = undefined;
        }
    }
    render() {
        return (index.h("div", { key: '9a7576679eabf4e8b396dd1de454fff1e6d28389', part: "form-control", class: {
                'form-control': true,
                'form-control--small': this.size === 'small',
                'form-control--medium': this.size === 'medium',
                'form-control--large': this.size === 'large',
            } }, index.h("sc-form-control", { key: 'cd75500e4b400e89a9012fe21ab5fcae1f89bfaa', exportparts: "label, help-text, form-control", size: this.size, required: this.required, label: this.label, showLabel: this.showLabel, help: this.help, inputId: this.inputId, helpId: this.helpId, labelId: this.labelId, name: this.name }, index.h("div", { key: 'c1fec2f51128b4b0b1380f3365b636319c496c0f', part: "form-control-input", class: "form-control-input" }, index.h("div", { key: 'ac2d70bd454a113db36f476a3285817bed4c95d2', part: "base", class: {
                'textarea': true,
                'textarea--small': this.size === 'small',
                'textarea--medium': this.size === 'medium',
                'textarea--large': this.size === 'large',
                'textarea--standard': !this.filled,
                'textarea--filled': this.filled,
                'textarea--disabled': this.disabled,
                'textarea--focused': this.hasFocus,
                'textarea--empty': !this.value,
                'textarea--invalid': this.invalid,
                'textarea--resize-none': this.resize === 'none',
                'textarea--resize-vertical': this.resize === 'vertical',
                'textarea--resize-auto': this.resize === 'auto',
            } }, index.h("textarea", { key: '35562c78edd851ee4d6439a2d31c75026ef1b4e7', part: "textarea", ref: el => (this.input = el), id: "input", class: "textarea__control", name: this.name, value: this.value, disabled: this.disabled, readonly: this.readonly, required: this.required, placeholder: this.placeholder, rows: this.rows, minlength: this.minlength, maxlength: this.maxlength, autocapitalize: this.autocapitalize, autocorrect: this.autocorrect, autofocus: this.autofocus, spellcheck: this.spellcheck, enterkeyhint: this.enterkeyhint, inputmode: this.inputmode, "aria-describedby": "help-text", onChange: () => this.handleChange(), onInput: () => this.handleInput(), onFocus: () => this.handleFocus(), onBlur: () => this.handleBlur(), onKeyDown: (e) => e.stopPropagation() })), this.showCharLimit && (index.h("div", { key: '8664ee8e325031f4cec7a7597a89a0d70e0fa4cb', slot: "help", class: 'textarea__char-limit-warning' }, wp.i18n.sprintf(wp.i18n.__('%d characters remaining', 'surecart'), this.maxlength - this.input.value.length)))))));
    }
    get el() { return index.getElement(this); }
    static get watchers() { return {
        "rows": ["handleRowsChange"],
        "value": ["handleValueChange"],
        "disabled": ["handleDisabledChange"]
    }; }
};
ScTextarea.style = ScTextareaStyle0;

exports.sc_cancel_discount = ScCancelDiscount;
exports.sc_cancel_survey = ScCancelSurvey;
exports.sc_subscription_cancel = ScSubscriptionCancel;
exports.sc_textarea = ScTextarea;

//# sourceMappingURL=sc-cancel-discount_4.cjs.entry.js.map