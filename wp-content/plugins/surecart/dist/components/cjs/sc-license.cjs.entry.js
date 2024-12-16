'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const lazy = require('./lazy-2b509fa7.js');
const fetch = require('./fetch-f25a0cb0.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scLicenseCss = ":host{display:block}.license__date{font-weight:var(--sc-font-weight-semibold)}.license__heading{display:flex;align-items:center;gap:1rem}.license__key{display:block}.close__button{position:absolute;top:0;right:0;font-size:22px;z-index:1}.license-cancel{display:grid;gap:0.5em}";
const ScLicenseStyle0 = scLicenseCss;

const ScLicense = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.deleteActivation = async () => {
            try {
                this.busy = true;
                await fetch.apiFetch({
                    path: `surecart/v1/activations/${this.selectedActivationId}`,
                    method: 'DELETE',
                });
                this.onCloseDeleteModal();
                await this.initialFetch();
            }
            catch (e) {
                console.error(e);
                this.deleteActivationError = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            }
            finally {
                this.busy = false;
            }
        };
        this.onCloseDeleteModal = () => {
            this.selectedActivationId = '';
            this.showConfirmDelete = false;
            this.busy = false;
            this.deleteActivationError = '';
        };
        this.licenseId = undefined;
        this.loading = false;
        this.error = '';
        this.license = undefined;
        this.copied = false;
        this.showConfirmDelete = false;
        this.selectedActivationId = '';
        this.deleteActivationError = '';
        this.busy = false;
    }
    /** Only fetch if visible */
    componentWillLoad() {
        lazy.onFirstVisible(this.el, () => {
            this.initialFetch();
        });
    }
    async initialFetch() {
        try {
            this.loading = true;
            await this.getLicense();
        }
        catch (e) {
            console.error(e);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.loading = false;
        }
    }
    async getLicense() {
        this.license = await fetch.apiFetch({
            path: addQueryArgs.addQueryArgs(`surecart/v1/licenses/${this.licenseId}`, {
                expand: ['activations', 'purchase', 'purchase.product'],
            }),
        });
    }
    async copyKey(key) {
        try {
            await navigator.clipboard.writeText(key);
            this.copied = true;
            setTimeout(() => {
                this.copied = false;
            }, 2000);
        }
        catch (err) {
            console.error(err);
            alert(wp.i18n.__('Error copying to clipboard', 'surecart'));
        }
    }
    renderStatus() {
        var _a, _b, _c, _d;
        if (((_a = this.license) === null || _a === void 0 ? void 0 : _a.status) === 'active') {
            return index.h("sc-tag", { type: "success" }, wp.i18n.__('Active', 'surecart'));
        }
        if (((_b = this.license) === null || _b === void 0 ? void 0 : _b.status) === 'revoked') {
            return index.h("sc-tag", { type: "danger" }, wp.i18n.__('Revoked', 'surecart'));
        }
        if (((_c = this.license) === null || _c === void 0 ? void 0 : _c.status) === 'inactive') {
            return index.h("sc-tag", { type: "info" }, wp.i18n.__('Inactive', 'surecart'));
        }
        return index.h("sc-tag", { type: "info" }, (_d = this.license) === null || _d === void 0 ? void 0 : _d.status);
    }
    renderLoading() {
        return (index.h("sc-dashboard-module", null, index.h("span", { slot: "heading" }, index.h("sc-skeleton", { style: { width: '120px' } })), index.h("sc-card", null, index.h("sc-stacked-list", null, index.h("sc-flex", { flexDirection: "column", style: { gap: '1em' } }, index.h("sc-skeleton", { style: { width: '20%', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '60%', display: 'inline-block' } }), index.h("sc-skeleton", { style: { width: '40%', display: 'inline-block' } }))))));
    }
    renderEmpty() {
        return index.h("sc-empty", { icon: "activity" }, wp.i18n.__('License not found.', 'surecart'));
    }
    renderLicenseHeader() {
        var _a;
        const purchase = (_a = this.license) === null || _a === void 0 ? void 0 : _a.purchase;
        const product = purchase === null || purchase === void 0 ? void 0 : purchase.product;
        return (index.h(index.Fragment, null, index.h("span", { slot: "heading" }, index.h("div", { class: "license__heading" }, product === null || product === void 0 ? void 0 :
            product.name, !this.loading && !purchase.live_mode && (index.h("sc-tag", { type: "warning", size: "small" }, wp.i18n.__('Test Mode', 'surecart')))))));
    }
    renderContent() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k;
        if (this.loading && !((_a = this.license) === null || _a === void 0 ? void 0 : _a.id)) {
            return this.renderLoading();
        }
        if (!((_b = this.license) === null || _b === void 0 ? void 0 : _b.id)) {
            return this.renderEmpty();
        }
        return (index.h(index.Fragment, null, index.h("sc-dashboard-module", { error: this.error }, this.renderLicenseHeader(), index.h("sc-card", { noPadding: true }, index.h("sc-stacked-list", null, index.h("sc-stacked-list-row", { style: { '--columns': '2', '--sc-stacked-list-row-align-items': 'center' } }, index.h("div", null, wp.i18n.__('License Status', 'surecart')), this.renderStatus()), index.h("sc-stacked-list-row", { style: { '--columns': '2' } }, index.h("div", null, wp.i18n.__('License Key', 'surecart')), index.h("div", { class: "license__key" }, index.h("sc-input", { value: (_c = this.license) === null || _c === void 0 ? void 0 : _c.key, readonly: true }, index.h("sc-button", { class: "license__copy", type: "default", size: "small", slot: "suffix", onClick: () => { var _a; return this.copyKey((_a = this.license) === null || _a === void 0 ? void 0 : _a.key); } }, this.copied ? wp.i18n.__('Copied!', 'surecart') : wp.i18n.__('Copy', 'surecart'))))), index.h("sc-stacked-list-row", { style: { '--columns': '2' } }, index.h("div", null, wp.i18n.__('Date', 'surecart')), index.h("sc-format-date", { date: (_d = this.license) === null || _d === void 0 ? void 0 : _d.created_at, type: "timestamp", month: "short", day: "numeric", year: "numeric" })), index.h("sc-stacked-list-row", { style: { '--columns': '2' } }, index.h("div", null, wp.i18n.__('Activations Count', 'surecart')), index.h("span", null, (_e = this.license) === null || _e === void 0 ? void 0 :
            _e.activation_count, " / ", ((_f = this.license) === null || _f === void 0 ? void 0 : _f.activation_limit) || index.h("span", null, "\u221E")))))), index.h("sc-dashboard-module", null, index.h("span", { slot: "heading" }, index.h("slot", { name: "heading" }, wp.i18n.__('Activations', 'surecart'))), index.h("sc-card", { noPadding: true }, !!((_j = (_h = (_g = this.license) === null || _g === void 0 ? void 0 : _g.activations) === null || _h === void 0 ? void 0 : _h.data) === null || _j === void 0 ? void 0 : _j.length) ? (index.h("sc-stacked-list", null, (_k = this.license) === null || _k === void 0 ? void 0 : _k.activations.data.map(activation => (index.h("sc-stacked-list-row", { style: { '--columns': '4' } }, index.h("sc-format-date", { class: "license__date", date: activation.created_at, type: "timestamp", month: "short", day: "numeric", year: "numeric" }), index.h("div", null, activation.name), index.h("div", null, activation.fingerprint), index.h("div", null, index.h("sc-button", { size: "small", onClick: () => {
                this.selectedActivationId = activation.id;
                this.showConfirmDelete = true;
            } }, "Delete"))))))) : (index.h("sc-empty", null, wp.i18n.__('No activations present.', 'surecart'))), this.loading && index.h("sc-block-ui", { style: { '--sc-block-ui-opacity': '0.75' }, spinner: true })))));
    }
    renderConfirmDelete() {
        return (index.h("sc-dialog", { open: this.showConfirmDelete, style: { '--body-spacing': 'var(--sc-spacing-x-large)' }, noHeader: true, onScRequestClose: this.onCloseDeleteModal }, index.h("sc-button", { class: "close__button", type: "text", circle: true, onClick: this.onCloseDeleteModal, disabled: this.loading }, index.h("sc-icon", { name: "x" })), index.h("sc-dashboard-module", { heading: wp.i18n.__('Delete Activation', 'surecart'), class: "license-cancel", error: this.error, style: { '--sc-dashboard-module-spacing': '1em' } }, index.h("span", { slot: "description" }, wp.i18n.__('Are you sure you want to delete activation?', 'surecart')), index.h("sc-flex", { justifyContent: "flex-start" }, index.h("sc-button", { type: "primary", disabled: this.loading || this.busy, onClick: this.deleteActivation }, wp.i18n.__('Delete Activation', 'surecart')), index.h("sc-button", { style: { color: 'var(--sc-color-gray-500' }, type: "text", onClick: this.onCloseDeleteModal, disabled: this.loading || this.busy }, wp.i18n.__('Cancel', 'surecart'))), this.busy && index.h("sc-block-ui", { style: { '--sc-block-ui-opacity': '0.75' }, spinner: true }))));
    }
    render() {
        return (index.h("sc-spacing", { key: '43cefcac974ad717fec5172b9398f1f27fbd9e8a', style: { '--spacing': 'var(--sc-spacing-large)' } }, this.renderContent(), this.renderConfirmDelete()));
    }
    get el() { return index.getElement(this); }
};
ScLicense.style = ScLicenseStyle0;

exports.sc_license = ScLicense;

//# sourceMappingURL=sc-license.cjs.entry.js.map