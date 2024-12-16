'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scFormatBytesCss = ":host{display:inline-block}";
const ScFormatBytesStyle0 = scFormatBytesCss;

const ScFormatBytes = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.locale = undefined;
        this.value = 0;
        this.unit = 'byte';
        this.display = 'short';
    }
    render() {
        if (isNaN(this.value)) {
            return '';
        }
        const bitPrefixes = ['', 'kilo', 'mega', 'giga', 'tera']; // petabit isn't a supported unit
        const bytePrefixes = ['', 'kilo', 'mega', 'giga', 'tera', 'peta'];
        const prefix = this.unit === 'bit' ? bitPrefixes : bytePrefixes;
        const index = Math.max(0, Math.min(Math.floor(Math.log10(this.value) / 3), prefix.length - 1));
        const unit = prefix[index] + this.unit;
        const valueToFormat = parseFloat((this.value / Math.pow(1000, index)).toPrecision(3));
        return new Intl.NumberFormat(this.locale, { style: 'unit', unit, unitDisplay: this.display }).format(valueToFormat);
    }
};
ScFormatBytes.style = ScFormatBytesStyle0;

exports.sc_format_bytes = ScFormatBytes;

//# sourceMappingURL=sc-format-bytes.cjs.entry.js.map