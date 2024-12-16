'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const mutations = require('./mutations-ca288ff4.js');
require('./fetch-f25a0cb0.js');
require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');
require('./store-d24717c6.js');
require('./utils-ee1bb9d3.js');
require('./index-bcdafe6e.js');
require('./watchers-cb566474.js');
require('./google-03835677.js');
require('./currency-71fce0f0.js');
require('./google-59d23803.js');
require('./util-b877b2bd.js');
require('./index-fb76df07.js');
require('./mutations-11c8f9a8.js');

const scUpsellNoThanksButtonCss = "sc-upsell-no-thanks-button{display:block}sc-upsell-no-thanks-button p{margin-block-start:0;margin-block-end:1em}sc-upsell-no-thanks-button .wp-block-button__link{position:relative;text-decoration:none}";
const ScUpsellNoThanksButtonStyle0 = scUpsellNoThanksButtonCss;

const ScUpsellNoThanksButton = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
    }
    render() {
        return (index.h(index.Host, { key: '490adbfe64f3c4661284cd74c85b56e4575b36fc', onClick: () => mutations.decline() }, index.h("slot", { key: 'ec79ec99b39e1e59c0e0f8d21eb2ad902fbd8aed' })));
    }
};
ScUpsellNoThanksButton.style = ScUpsellNoThanksButtonStyle0;

exports.sc_upsell_no_thanks_button = ScUpsellNoThanksButton;

//# sourceMappingURL=sc-upsell-no-thanks-button.cjs.entry.js.map