'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const getters$1 = require('./getters-36e9dc10.js');
const mutations = require('./mutations-11c8f9a8.js');
const getters = require('./getters-690e042a.js');
const store = require('./store-1fb3d249.js');
require('./index-fb76df07.js');
require('./index-bcdafe6e.js');
require('./utils-ee1bb9d3.js');

const scCheckoutFormErrorsCss = ":host{display:block}ul{margin:6px 0px;padding:0px;list-style:none}";
const ScCheckoutFormErrorsStyle0 = scCheckoutFormErrorsCss;

const ScCheckoutFormErrors = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.removeStateListener = () => { };
    }
    /**
     * Get the alert type.
     * @returns string
     */
    getAlertType() {
        switch (mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.type) {
            case 'error':
                return 'danger';
            case 'default':
                return 'primary';
            default:
                return mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.type;
        }
    }
    componentWillLoad() {
        // remove notice if finalizing or updating.
        this.removeStateListener = store.onChange('formState', () => {
            if (['finalizing', 'updating'].includes(getters.currentFormState())) {
                mutations.removeNotice();
            }
        });
    }
    disconnectedCallback() {
        this.removeStateListener();
    }
    getTopLevelError() {
        var _a;
        // checkout invalid is not friendly.
        if ((mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.code) === 'checkout.invalid' && ((_a = getters$1.getAdditionalErrorMessages()) === null || _a === void 0 ? void 0 : _a.length)) {
            return '';
        }
        return mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.message;
    }
    render() {
        // don't show component if no error message or is finalizing or updating.
        if (!(mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.message) || ['finalizing', 'updating'].includes(getters.currentFormState())) {
            return index.h(index.Host, { style: { display: 'none' } });
        }
        return (index.h(index.Host, null, index.h("sc-alert", { type: this.getAlertType(), scrollOnOpen: true, open: !!(mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.message), closable: !!(mutations.state === null || mutations.state === void 0 ? void 0 : mutations.state.dismissible) }, !!this.getTopLevelError() && index.h("span", { slot: "title", innerHTML: this.getTopLevelError() }), (getters$1.getAdditionalErrorMessages() || []).map((message, index$1) => (index.h("div", { innerHTML: message, key: index$1 })))), index.h("slot", null)));
    }
};
ScCheckoutFormErrors.style = ScCheckoutFormErrorsStyle0;

exports.sc_checkout_form_errors = ScCheckoutFormErrors;

//# sourceMappingURL=sc-checkout-form-errors.cjs.entry.js.map