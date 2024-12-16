import { r as registerInstance } from './index-745b6bec.js';
import { t as translateInterval } from './price-d5770168.js';
import './currency-a0c9bff4.js';

const ScFormatInterval = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.value = 0;
        this.interval = '';
        this.every = '/';
        this.fallback = '';
    }
    render() {
        return translateInterval(this.value, this.interval, ` ${this.every}`, this.fallback);
    }
};

export { ScFormatInterval as sc_format_interval };

//# sourceMappingURL=sc-format-interval.entry.js.map