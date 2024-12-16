import { r as registerInstance, h } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';

const scCustomerEditCss = ":host{display:block;position:relative}.customer-edit{display:grid;gap:0.75em}";
const ScCustomerEditStyle0 = scCustomerEditCss;

const ScCustomerEdit = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.heading = undefined;
        this.customer = undefined;
        this.successUrl = undefined;
        this.loading = undefined;
        this.error = undefined;
    }
    async handleSubmit(e) {
        var _a;
        this.loading = true;
        try {
            const { email, first_name, last_name, phone, billing_matches_shipping, shipping_name, shipping_city, 'tax_identifier.number_type': tax_identifier_number_type, 'tax_identifier.number': tax_identifier_number, shipping_country, shipping_line_1, shipping_postal_code, shipping_state, billing_name, billing_city, billing_country, billing_line_1, billing_postal_code, billing_state, } = await e.target.getFormJson();
            this.customer.billing_address = {
                name: billing_name,
                city: billing_city,
                country: billing_country,
                line_1: billing_line_1,
                postal_code: billing_postal_code,
                state: billing_state,
            };
            this.customer.shipping_address = {
                name: shipping_name,
                city: shipping_city,
                country: shipping_country,
                line_1: shipping_line_1,
                postal_code: shipping_postal_code,
                state: shipping_state,
            };
            await apiFetch({
                path: addQueryArgs(`surecart/v1/customers/${(_a = this.customer) === null || _a === void 0 ? void 0 : _a.id}`, { expand: ['tax_identifier'] }),
                method: 'PATCH',
                data: {
                    email,
                    first_name,
                    last_name,
                    phone,
                    billing_matches_shipping: billing_matches_shipping === 'on',
                    shipping_address: this.customer.shipping_address,
                    billing_address: this.customer.billing_address,
                    ...(tax_identifier_number && tax_identifier_number_type
                        ? {
                            tax_identifier: {
                                number: tax_identifier_number,
                                number_type: tax_identifier_number_type,
                            },
                        }
                        : {}),
                },
            });
            if (this.successUrl) {
                window.location.assign(this.successUrl);
            }
            else {
                this.loading = false;
            }
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            this.loading = false;
        }
    }
    render() {
        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m;
        return (h("sc-dashboard-module", { key: '6a80f5d18edd486644228f8625add5aa5d92b618', class: "customer-edit", error: this.error }, h("span", { key: 'ae809949d36c363e0a66dbbcaa87b2816d059600', slot: "heading" }, this.heading || wp.i18n.__('Update Billing Details', 'surecart'), ' ', !((_a = this === null || this === void 0 ? void 0 : this.customer) === null || _a === void 0 ? void 0 : _a.live_mode) && (h("sc-tag", { key: '7efa26b592501800cf12dab8cb60c6c5a29626bb', type: "warning", size: "small" }, wp.i18n.__('Test', 'surecart')))), h("sc-card", { key: '27aa789a6a083bb38d2da9646cb6ca6896096fa1' }, h("sc-form", { key: '17f04e362bcf3c26c3f10e08788f85c80ea50f4f', onScFormSubmit: e => this.handleSubmit(e) }, h("sc-columns", { key: 'f40e94777de92800c84ea1a8dd7cb27956e669aa', style: { '--sc-column-spacing': 'var(--sc-spacing-medium)' } }, h("sc-column", { key: 'f5001fdd9c76b50377b40633802db547a880d631' }, h("sc-input", { key: '1ec1c015c386ea9f4696d228b37c3d18b18f3938', label: wp.i18n.__('First Name', 'surecart'), name: "first_name", value: (_b = this.customer) === null || _b === void 0 ? void 0 : _b.first_name })), h("sc-column", { key: 'a76e8654ed41109b3ba2630579dbfff45ea313e5' }, h("sc-input", { key: '3d889208fd87b6193ef90860436ea213305d2153', label: wp.i18n.__('Last Name', 'surecart'), name: "last_name", value: (_c = this.customer) === null || _c === void 0 ? void 0 : _c.last_name }))), h("sc-column", { key: '4d84c0ee547d0af8b76bea9ac2a93884b0c63284' }, h("sc-phone-input", { key: 'fe73a222406445d6d3ccb23fbe9cad1d7ba7c941', label: wp.i18n.__('Phone', 'surecart'), name: "phone", value: (_d = this.customer) === null || _d === void 0 ? void 0 : _d.phone })), h("sc-flex", { key: 'd286bee1b8bca9f982a9ab4113f3d2a85377adf3', style: { '--sc-flex-column-gap': 'var(--sc-spacing-medium)' }, flexDirection: "column" }, h("div", { key: '61d0875d601faf07f4b7b30ecf690927cac3847e' }, h("sc-address", { key: '23cb05dcc7da0a5fdd207f42d764a7b0a607f082', label: wp.i18n.__('Shipping Address', 'surecart'), showName: true, address: {
                ...(_e = this.customer) === null || _e === void 0 ? void 0 : _e.shipping_address,
            }, required: false, names: {
                name: 'shipping_name',
                country: 'shipping_country',
                line_1: 'shipping_line_1',
                line_2: 'shipping_line_2',
                city: 'shipping_city',
                postal_code: 'shipping_postal_code',
                state: 'shipping_state',
            } })), h("div", { key: 'ad1891d92f583d1c794f3c0c8a51ad3ad5e948e2' }, h("sc-checkbox", { key: '5fe4d37638daf1423abd674165ff6ff796588933', name: "billing_matches_shipping", checked: (_f = this.customer) === null || _f === void 0 ? void 0 : _f.billing_matches_shipping, onScChange: e => {
                this.customer = {
                    ...this.customer,
                    billing_matches_shipping: e.target.checked,
                };
            } }, wp.i18n.__('Billing address is same as shipping', 'surecart'))), h("div", { key: '31f5bd6836ac84aaeaa689a757aad6aceed3a321', style: { display: ((_g = this.customer) === null || _g === void 0 ? void 0 : _g.billing_matches_shipping) ? 'none' : 'block' } }, h("sc-address", { key: '2c98bb60a1adfc2b7e0f886fa13601a105065c49', label: wp.i18n.__('Billing Address', 'surecart'), showName: true, address: {
                ...(_h = this.customer) === null || _h === void 0 ? void 0 : _h.billing_address,
            }, names: {
                name: 'billing_name',
                country: 'billing_country',
                line_1: 'billing_line_1',
                line_2: 'billing_line_2',
                city: 'billing_city',
                postal_code: 'billing_postal_code',
                state: 'billing_state',
            }, required: true })), h("sc-tax-id-input", { key: '669b4648ab4bdcaa429c941014ca4fd474660d50', show: true, number: (_k = (_j = this.customer) === null || _j === void 0 ? void 0 : _j.tax_identifier) === null || _k === void 0 ? void 0 : _k.number, type: (_m = (_l = this.customer) === null || _l === void 0 ? void 0 : _l.tax_identifier) === null || _m === void 0 ? void 0 : _m.number_type })), h("div", { key: 'd79a0c5a721f185d3d9fd021e45171415de08f39' }, h("sc-button", { key: '0497de2d5a945fa48635b7786cc466d9bd270e48', type: "primary", full: true, submit: true }, wp.i18n.__('Save', 'surecart'))))), this.loading && h("sc-block-ui", { key: '4aab1bfae38859c880e6597183601c83868b08a6', spinner: true })));
    }
};
ScCustomerEdit.style = ScCustomerEditStyle0;

export { ScCustomerEdit as sc_customer_edit };

//# sourceMappingURL=sc-customer-edit.entry.js.map