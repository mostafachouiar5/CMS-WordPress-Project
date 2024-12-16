import { r as registerInstance } from './index-745b6bec.js';

const scFormatBytesCss = ":host{display:inline-block}";
const ScFormatBytesStyle0 = scFormatBytesCss;

const ScFormatBytes = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
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

export { ScFormatBytes as sc_format_bytes };

//# sourceMappingURL=sc-format-bytes.entry.js.map