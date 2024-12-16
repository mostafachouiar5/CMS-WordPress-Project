import { r as registerInstance, h } from './index-745b6bec.js';

const scVisuallyHiddenCss = ":host(:not(:focus-within)){position:absolute !important;width:1px !important;height:1px !important;clip:rect(0 0 0 0) !important;clip-path:inset(50%) !important;border:none !important;overflow:hidden !important;white-space:nowrap !important;padding:0 !important}";
const ScVisuallyHiddenStyle0 = scVisuallyHiddenCss;

const ScVisuallyHidden = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
    }
    render() {
        return h("slot", { key: 'a4f36920febc4b63c38c2029f19a73dabf0e2908' });
    }
};
ScVisuallyHidden.style = ScVisuallyHiddenStyle0;

export { ScVisuallyHidden as sc_visually_hidden };

//# sourceMappingURL=sc-visually-hidden.entry.js.map