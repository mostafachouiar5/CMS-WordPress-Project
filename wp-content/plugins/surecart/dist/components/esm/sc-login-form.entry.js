import { r as registerInstance, h, F as Fragment } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';

const scLoginFormCss = ".login-form{font-size:16px;margin:var(--sc-spacing-xx-large) auto;max-width:400px;position:relative}.login-form__title{margin-bottom:var(--sc-spacing-medium);font-size:var(--sc-font-size-xx-large);font-weight:var(--sc-font-weight-bold);line-height:var(--sc-line-height-dense);text-align:var(--sc-login-text-align, center)}.login-form__back{text-align:center;font-size:var(--sc-font-size-small)}sc-card{--sc-card-padding:var(--sc-spacing-xx-large)}";
const ScLoginFormStyle0 = scLoginFormCss;

const ScLogin = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.step = 0;
        this.email = '';
        this.password = '';
        this.verifyCode = '';
        this.loading = undefined;
        this.error = undefined;
    }
    /** Focus the password field automatically on password step. */
    handleStepChange() {
        if (this.step === 1) {
            setTimeout(() => {
                var _a, _b;
                (_b = (_a = this.passwordInput) === null || _a === void 0 ? void 0 : _a.triggerFocus) === null || _b === void 0 ? void 0 : _b.call(_a);
            }, 50);
        }
        if (this.step === 2) {
            setTimeout(() => {
                var _a, _b;
                (_b = (_a = this.codeInput) === null || _a === void 0 ? void 0 : _a.triggerFocus) === null || _b === void 0 ? void 0 : _b.call(_a);
            }, 50);
        }
    }
    /** Clear out error when loading happens. */
    handleLoadingChange(val) {
        if (val) {
            this.error = null;
        }
    }
    handleVerifyCodeChange(val) {
        if ((val === null || val === void 0 ? void 0 : val.length) >= 6) {
            this.submitCode();
        }
    }
    /** Handle request errors. */
    handleError(e) {
        console.error(this.error);
        this.error = e || { message: wp.i18n.__('Something went wrong', 'surecart') };
    }
    /** Submit for verification codes */
    async createLoginCode() {
        try {
            this.loading = true;
            await apiFetch({
                method: 'POST',
                path: 'surecart/v1/verification_codes',
                data: {
                    login: this.email,
                },
            });
            this.step = this.step + 1;
        }
        catch (e) {
            this.handleError(e);
        }
        finally {
            this.loading = false;
        }
    }
    /** Get all subscriptions */
    async submitCode() {
        try {
            this.loading = true;
            const { verified } = (await apiFetch({
                method: 'POST',
                path: 'surecart/v1/verification_codes/verify',
                data: {
                    login: this.email,
                    code: this.verifyCode,
                },
            }));
            if (!verified) {
                throw { message: wp.i18n.__('Verification code is not valid. Please try again.', 'surecart') };
            }
            window.location.reload();
        }
        catch (e) {
            this.handleError(e);
            this.loading = false;
        }
    }
    async login() {
        try {
            this.loading = true;
            const { redirect_url } = (await apiFetch({
                method: 'POST',
                path: 'surecart/v1/login',
                data: {
                    login: this.email,
                    password: this.password,
                },
            }));
            if (redirect_url) {
                window.location.replace(redirect_url);
            }
            else {
                window.location.reload();
            }
        }
        catch (e) {
            this.handleError(e);
            this.loading = false;
        }
    }
    async checkEmail() {
        try {
            this.loading = true;
            await apiFetch({
                method: 'POST',
                path: 'surecart/v1/check_email',
                data: {
                    login: this.email,
                },
            });
            this.step = this.step + 1;
        }
        catch (e) {
            this.handleError(e);
        }
        finally {
            this.loading = false;
        }
    }
    renderInner() {
        if (this.step === 2) {
            return (h(Fragment, null, h("div", { class: "login-form__title", part: "title" }, wp.i18n.__('Check your email for a confirmation code', 'surecart')), h("div", null, h("sc-form", { onScFormSubmit: () => this.submitCode() }, h("sc-input", { label: wp.i18n.__('Confirmation code', 'surecart'), type: "text", ref: el => (this.codeInput = el), autofocus: true, required: true, onScInput: e => (this.verifyCode = e.target.value) }), h("sc-button", { type: "primary", submit: true, full: true }, h("sc-icon", { name: "lock", slot: "prefix" }), wp.i18n.__('Login with Code', 'surecart'))))));
        }
        if (this.step === 1 && this.email) {
            return (h(Fragment, null, h("div", { class: "login-form__title", part: "title" }, h("div", null, wp.i18n.__('Welcome', 'surecart')), h("sc-button", { style: { fontSize: '18px' }, size: "small", pill: true, caret: true, onClick: () => (this.step = this.step - 1) }, h("sc-icon", { name: "user", slot: "prefix" }), this.email)), h("sc-flex", { flexDirection: "column", style: { '--sc-flex-column-gap': 'var(--sc-spacing-large)' } }, h("div", null, h("sc-form", { onScFormSubmit: () => this.createLoginCode() }, h("sc-button", { class: "login-code", type: "primary", submit: true, full: true }, h("sc-icon", { name: "mail", slot: "prefix" }), wp.i18n.__('Send a login code', 'surecart'))), h("sc-divider", { style: { '--spacing': '0.5em' } }, wp.i18n.__('or', 'surecart')), h("sc-form", { onScFormSubmit: () => this.login() }, h("sc-input", { label: wp.i18n.__('Enter your password', 'surecart'), type: "password", ref: el => (this.passwordInput = el), onKeyDown: e => e.key === 'Enter' && this.login(), autofocus: true, required: true, onScInput: e => (this.password = e.target.value) }), h("sc-button", { type: "primary", outline: true, submit: true, full: true }, h("sc-icon", { name: "lock", slot: "prefix" }), wp.i18n.__('Login', 'surecart')))))));
        }
        return (h(Fragment, null, h("div", { class: "login-form__title", part: "title" }, h("slot", { name: "title" })), h("sc-form", { onScFormSubmit: () => this.checkEmail() }, h("sc-input", { type: "text", value: this.email, label: wp.i18n.__('Username or Email Address', 'surecart'), onScInput: e => (this.email = e.target.value), onKeyDown: e => e.key === 'Enter' && this.checkEmail(), required: true, autofocus: true }), h("sc-button", { type: "primary", submit: true, full: true }, h("sc-icon", { name: "arrow-right", slot: "suffix" }), wp.i18n.__('Next', 'surecart')))));
    }
    render() {
        var _a, _b;
        return (h("div", { key: 'a5dc72cbce20c6561b7f475f8f7357bc064cf99e', class: "login-form" }, h("sc-card", { key: '725f4531c1f40548faffb12fca0c4632df847e8e' }, !!this.error && (h("sc-alert", { key: 'bd75b6cd331a83456621cf4fec9c244b5ba5d354', open: true, type: "danger", closable: true, onScHide: () => (this.error = null) }, h("span", { key: '1d825ab9eedfaeadea9d260093165333d7bbbe05', slot: "title", innerHTML: (_a = this.error) === null || _a === void 0 ? void 0 : _a.message }), (((_b = this.error) === null || _b === void 0 ? void 0 : _b.additional_errors) || []).map(({ message }) => (h("div", { innerHTML: message }))))), this.renderInner()), this.loading && h("sc-block-ui", { key: '721665c3210a8a0a6546cac84e87a10aa15ba5b3', spinner: true, style: { 'zIndex': '9', '--sc-block-ui-opacity': '0.5' } })));
    }
    static get watchers() { return {
        "step": ["handleStepChange"],
        "loading": ["handleLoadingChange"],
        "verifyCode": ["handleVerifyCodeChange"]
    }; }
};
ScLogin.style = ScLoginFormStyle0;

export { ScLogin as sc_login_form };

//# sourceMappingURL=sc-login-form.entry.js.map