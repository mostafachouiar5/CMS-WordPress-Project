'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const address = require('./address-4c70d641.js');
const tax = require('./tax-736ff458.js');

var commonjsGlobal = typeof globalThis !== 'undefined' ? globalThis : typeof window !== 'undefined' ? window : typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : {};

var index_umd = {exports: {}};

(function (module, exports) {
(function (global, factory) {
    factory(exports) ;
})(commonjsGlobal, (function (exports) {
    // This file is auto-generated via "npm run update-formats". Do not alter manually!
    const addressFormats = new Map([
        ['AC', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['AD', { local: '%N%n%O%n%A%n%Z %C' }],
        ['AE', { local: '%N%n%O%n%A%n%S', latin: '%N%n%O%n%A%n%S' }],
        ['AF', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['AI', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['AL', { local: '%N%n%O%n%A%n%Z%n%C' }],
        ['AM', { local: '%N%n%O%n%A%n%Z%n%C%n%S', latin: '%N%n%O%n%A%n%Z%n%C%n%S' }],
        ['AR', { local: '%N%n%O%n%A%n%Z %C%n%S' }],
        ['AS', { local: '%N%n%O%n%A%n%C %S %Z' }],
        ['AT', { local: '%O%n%N%n%A%n%Z %C' }],
        ['AU', { local: '%O%n%N%n%A%n%C %S %Z' }],
        ['AX', { local: '%O%n%N%n%A%nAX-%Z %C%nÅLAND' }],
        ['AZ', { local: '%N%n%O%n%A%nAZ %Z %C' }],
        ['BA', { local: '%N%n%O%n%A%n%Z %C' }],
        ['BB', { local: '%N%n%O%n%A%n%C, %S %Z' }],
        ['BD', { local: '%N%n%O%n%A%n%C - %Z' }],
        ['BE', { local: '%O%n%N%n%A%n%Z %C' }],
        ['BF', { local: '%N%n%O%n%A%n%C %X' }],
        ['BG', { local: '%N%n%O%n%A%n%Z %C' }],
        ['BH', { local: '%N%n%O%n%A%n%C %Z' }],
        ['BL', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['BM', { local: '%N%n%O%n%A%n%C %Z' }],
        ['BN', { local: '%N%n%O%n%A%n%C %Z' }],
        ['BR', { local: '%O%n%N%n%A%n%D%n%C-%S%n%Z' }],
        ['BS', { local: '%N%n%O%n%A%n%C, %S' }],
        ['BT', { local: '%N%n%O%n%A%n%C %Z' }],
        ['BY', { local: '%O%n%N%n%A%n%Z, %C%n%S' }],
        ['CA', { local: '%N%n%O%n%A%n%C %S %Z' }],
        ['CC', { local: '%O%n%N%n%A%n%C %S %Z' }],
        ['CH', { local: '%O%n%N%n%A%nCH-%Z %C' }],
        ['CI', { local: '%N%n%O%n%X %A %C %X' }],
        ['CL', { local: '%N%n%O%n%A%n%Z %C%n%S' }],
        ['CN', { local: '%Z%n%S%C%D%n%A%n%O%n%N', latin: '%N%n%O%n%A%n%D%n%C%n%S, %Z' }],
        ['CO', { local: '%N%n%O%n%A%n%D%n%C, %S, %Z' }],
        ['CR', { local: '%N%n%O%n%A%n%S, %C%n%Z' }],
        ['CU', { local: '%N%n%O%n%A%n%C %S%n%Z' }],
        ['CV', { local: '%N%n%O%n%A%n%Z %C%n%S' }],
        ['CX', { local: '%O%n%N%n%A%n%C %S %Z' }],
        ['CY', { local: '%N%n%O%n%A%n%Z %C' }],
        ['CZ', { local: '%N%n%O%n%A%n%Z %C' }],
        ['DE', { local: '%N%n%O%n%A%n%Z %C' }],
        ['DK', { local: '%N%n%O%n%A%n%Z %C' }],
        ['DO', { local: '%N%n%O%n%A%n%Z %C' }],
        ['DZ', { local: '%N%n%O%n%A%n%Z %C' }],
        ['EC', { local: '%N%n%O%n%A%n%Z%n%C' }],
        ['EE', { local: '%N%n%O%n%A%n%Z %C %S' }],
        ['EG', { local: '%N%n%O%n%A%n%C%n%S%n%Z', latin: '%N%n%O%n%A%n%C%n%S%n%Z' }],
        ['EH', { local: '%N%n%O%n%A%n%Z %C' }],
        ['ES', { local: '%N%n%O%n%A%n%Z %C %S' }],
        ['ET', { local: '%N%n%O%n%A%n%Z %C' }],
        ['FI', { local: '%O%n%N%n%A%nFI-%Z %C' }],
        ['FK', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['FM', { local: '%N%n%O%n%A%n%C %S %Z' }],
        ['FO', { local: '%N%n%O%n%A%nFO%Z %C' }],
        ['FR', { local: '%O%n%N%n%A%n%Z %C' }],
        ['GB', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['GE', { local: '%N%n%O%n%A%n%Z %C' }],
        ['GF', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['GG', { local: '%N%n%O%n%A%n%C%nGUERNSEY%n%Z' }],
        ['GI', { local: '%N%n%O%n%A%nGIBRALTAR%n%Z' }],
        ['GL', { local: '%N%n%O%n%A%n%Z %C' }],
        ['GN', { local: '%N%n%O%n%Z %A %C' }],
        ['GP', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['GR', { local: '%N%n%O%n%A%n%Z %C' }],
        ['GS', { local: '%N%n%O%n%A%n%n%C%n%Z' }],
        ['GT', { local: '%N%n%O%n%A%n%Z- %C' }],
        ['GU', { local: '%N%n%O%n%A%n%C %Z' }],
        ['GW', { local: '%N%n%O%n%A%n%Z %C' }],
        ['HK', { local: '%S%n%C%n%A%n%O%n%N', latin: '%N%n%O%n%A%n%C%n%S' }],
        ['HM', { local: '%O%n%N%n%A%n%C %S %Z' }],
        ['HN', { local: '%N%n%O%n%A%n%C, %S%n%Z' }],
        ['HR', { local: '%N%n%O%n%A%nHR-%Z %C' }],
        ['HT', { local: '%N%n%O%n%A%nHT%Z %C' }],
        ['HU', { local: '%N%n%O%n%C%n%A%n%Z' }],
        ['ID', { local: '%N%n%O%n%A%n%C%n%S %Z' }],
        ['IE', { local: '%N%n%O%n%A%n%D%n%C%n%S%n%Z' }],
        ['IL', { local: '%N%n%O%n%A%n%C %Z' }],
        ['IM', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['IN', { local: '%N%n%O%n%A%n%C %Z%n%S' }],
        ['IO', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['IQ', { local: '%O%n%N%n%A%n%C, %S%n%Z' }],
        ['IR', { local: '%O%n%N%n%S%n%C, %D%n%A%n%Z' }],
        ['IS', { local: '%N%n%O%n%A%n%Z %C' }],
        ['IT', { local: '%N%n%O%n%A%n%Z %C %S' }],
        ['JE', { local: '%N%n%O%n%A%n%C%nJERSEY%n%Z' }],
        ['JM', { local: '%N%n%O%n%A%n%C%n%S %X' }],
        ['JO', { local: '%N%n%O%n%A%n%C %Z' }],
        ['JP', { local: '〒%Z%n%S%n%A%n%O%n%N', latin: '%N%n%O%n%A, %S%n%Z' }],
        ['KE', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['KG', { local: '%N%n%O%n%A%n%Z %C' }],
        ['KH', { local: '%N%n%O%n%A%n%C %Z' }],
        ['KI', { local: '%N%n%O%n%A%n%S%n%C' }],
        ['KN', { local: '%N%n%O%n%A%n%C, %S' }],
        ['KP', { local: '%Z%n%S%n%C%n%A%n%O%n%N', latin: '%N%n%O%n%A%n%C%n%S, %Z' }],
        ['KR', { local: '%S %C%D%n%A%n%O%n%N%n%Z', latin: '%N%n%O%n%A%n%D%n%C%n%S%n%Z' }],
        ['KW', { local: '%N%n%O%n%A%n%Z %C' }],
        ['KY', { local: '%N%n%O%n%A%n%S %Z' }],
        ['KZ', { local: '%Z%n%S%n%C%n%A%n%O%n%N' }],
        ['LA', { local: '%N%n%O%n%A%n%Z %C' }],
        ['LB', { local: '%N%n%O%n%A%n%C %Z' }],
        ['LI', { local: '%O%n%N%n%A%nFL-%Z %C' }],
        ['LK', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['LR', { local: '%N%n%O%n%A%n%Z %C' }],
        ['LS', { local: '%N%n%O%n%A%n%C %Z' }],
        ['LT', { local: '%O%n%N%n%A%nLT-%Z %C %S' }],
        ['LU', { local: '%O%n%N%n%A%nL-%Z %C' }],
        ['LV', { local: '%N%n%O%n%A%n%S%n%C, %Z' }],
        ['MA', { local: '%N%n%O%n%A%n%Z %C' }],
        ['MC', { local: '%N%n%O%n%A%nMC-%Z %C %X' }],
        ['MD', { local: '%N%n%O%n%A%nMD-%Z %C' }],
        ['ME', { local: '%N%n%O%n%A%n%Z %C' }],
        ['MF', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['MG', { local: '%N%n%O%n%A%n%Z %C' }],
        ['MH', { local: '%N%n%O%n%A%n%C %S %Z' }],
        ['MK', { local: '%N%n%O%n%A%n%Z %C' }],
        ['MM', { local: '%N%n%O%n%A%n%C, %Z' }],
        ['MN', { local: '%N%n%O%n%A%n%C%n%S %Z' }],
        ['MO', { local: '%A%n%O%n%N', latin: '%N%n%O%n%A' }],
        ['MP', { local: '%N%n%O%n%A%n%C %S %Z' }],
        ['MQ', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['MT', { local: '%N%n%O%n%A%n%C %Z' }],
        ['MU', { local: '%N%n%O%n%A%n%Z%n%C' }],
        ['MV', { local: '%N%n%O%n%A%n%C %Z' }],
        ['MW', { local: '%N%n%O%n%A%n%C %X' }],
        ['MX', { local: '%N%n%O%n%A%n%D%n%Z %C, %S' }],
        ['MY', { local: '%N%n%O%n%A%n%D%n%Z %C%n%S' }],
        ['MZ', { local: '%N%n%O%n%A%n%Z %C%S' }],
        ['NA', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['NC', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['NE', { local: '%N%n%O%n%A%n%Z %C' }],
        ['NF', { local: '%O%n%N%n%A%n%C %S %Z' }],
        ['NG', { local: '%N%n%O%n%A%n%D%n%C %Z%n%S' }],
        ['NI', { local: '%N%n%O%n%A%n%Z%n%C, %S' }],
        ['NL', { local: '%O%n%N%n%A%n%Z %C' }],
        ['NO', { local: '%N%n%O%n%A%n%Z %C' }],
        ['NP', { local: '%N%n%O%n%A%n%C %Z' }],
        ['NR', { local: '%N%n%O%n%A%n%S' }],
        ['NZ', { local: '%N%n%O%n%A%n%D%n%C %Z' }],
        ['OM', { local: '%N%n%O%n%A%n%Z%n%C' }],
        ['PA', { local: '%N%n%O%n%A%n%C%n%S' }],
        ['PE', { local: '%N%n%O%n%A%n%C %Z%n%S' }],
        ['PF', { local: '%N%n%O%n%A%n%Z %C %S' }],
        ['PG', { local: '%N%n%O%n%A%n%C %Z %S' }],
        ['PH', { local: '%N%n%O%n%A%n%D, %C%n%Z %S' }],
        ['PK', { local: '%N%n%O%n%A%n%D%n%C-%Z' }],
        ['PL', { local: '%N%n%O%n%A%n%Z %C' }],
        ['PM', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['PN', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['PR', { local: '%N%n%O%n%A%n%C PR %Z' }],
        ['PT', { local: '%N%n%O%n%A%n%Z %C' }],
        ['PW', { local: '%N%n%O%n%A%n%C %S %Z' }],
        ['PY', { local: '%N%n%O%n%A%n%Z %C' }],
        ['RE', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['RO', { local: '%N%n%O%n%A%n%Z %S %C' }],
        ['RS', { local: '%N%n%O%n%A%n%Z %C' }],
        ['RU', { local: '%N%n%O%n%A%n%C%n%S%n%Z', latin: '%N%n%O%n%A%n%C%n%S%n%Z' }],
        ['SA', { local: '%N%n%O%n%A%n%C %Z' }],
        ['SC', { local: '%N%n%O%n%A%n%C%n%S' }],
        ['SD', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['SE', { local: '%O%n%N%n%A%nSE-%Z %C' }],
        ['SG', { local: '%N%n%O%n%A%nSINGAPORE %Z' }],
        ['SH', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['SI', { local: '%N%n%O%n%A%nSI-%Z %C' }],
        ['SJ', { local: '%N%n%O%n%A%n%Z %C' }],
        ['SK', { local: '%N%n%O%n%A%n%Z %C' }],
        ['SM', { local: '%N%n%O%n%A%n%Z %C' }],
        ['SN', { local: '%N%n%O%n%A%n%Z %C' }],
        ['SO', { local: '%N%n%O%n%A%n%C, %S %Z' }],
        ['SR', { local: '%N%n%O%n%A%n%C%n%S' }],
        ['SV', { local: '%N%n%O%n%A%n%Z-%C%n%S' }],
        ['SZ', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['TA', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['TC', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['TH', { local: '%N%n%O%n%A%n%D %C%n%S %Z', latin: '%N%n%O%n%A%n%D, %C%n%S %Z' }],
        ['TJ', { local: '%N%n%O%n%A%n%Z %C' }],
        ['TM', { local: '%N%n%O%n%A%n%Z %C' }],
        ['TN', { local: '%N%n%O%n%A%n%Z %C' }],
        ['TR', { local: '%N%n%O%n%A%n%Z %C/%S' }],
        ['TV', { local: '%N%n%O%n%A%n%C%n%S' }],
        ['TW', { local: '%Z%n%S%C%n%A%n%O%n%N', latin: '%N%n%O%n%A%n%C, %S %Z' }],
        ['TZ', { local: '%N%n%O%n%A%n%Z %C' }],
        ['UA', { local: '%N%n%O%n%A%n%C%n%S%n%Z', latin: '%N%n%O%n%A%n%C%n%S%n%Z' }],
        ['UM', { local: '%N%n%O%n%A%n%C %S %Z' }],
        ['US', { local: '%N%n%O%n%A%n%C, %S %Z' }],
        ['UY', { local: '%N%n%O%n%A%n%Z %C %S' }],
        ['UZ', { local: '%N%n%O%n%A%n%Z %C%n%S' }],
        ['VA', { local: '%N%n%O%n%A%n%Z %C' }],
        ['VC', { local: '%N%n%O%n%A%n%C %Z' }],
        ['VE', { local: '%N%n%O%n%A%n%C %Z, %S' }],
        ['VG', { local: '%N%n%O%n%A%n%C%n%Z' }],
        ['VI', { local: '%N%n%O%n%A%n%C %S %Z' }],
        ['VN', { local: '%N%n%O%n%A%n%C%n%S %Z', latin: '%N%n%O%n%A%n%C%n%S %Z' }],
        ['WF', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['XK', { local: '%N%n%O%n%A%n%Z %C' }],
        ['YT', { local: '%O%n%N%n%A%n%Z %C %X' }],
        ['ZA', { local: '%N%n%O%n%A%n%D%n%C%n%Z' }],
        ['ZM', { local: '%N%n%O%n%A%n%Z %C' }],
    ]);
    const defaultAddressFormat = '%N%n%O%n%A%n%C';

    const getFormatString = (countryCode, scriptType) => {
        var _a;
        const format = addressFormats.get(countryCode.toUpperCase());
        if (!format) {
            return defaultAddressFormat;
        }
        return (_a = format[scriptType]) !== null && _a !== void 0 ? _a : format.local;
    };
    const getFormatSubstrings = (format) => {
        const parts = [];
        let escaped = false;
        let currentLiteral = '';
        for (const char of format) {
            if (escaped) {
                escaped = false;
                parts.push(`%${char}`);
                continue;
            }
            if (char !== '%') {
                currentLiteral += char;
                continue;
            }
            if (currentLiteral.length > 0) {
                parts.push(currentLiteral);
                currentLiteral = '';
            }
            escaped = true;
        }
        if (currentLiteral.length > 0) {
            parts.push(currentLiteral);
        }
        return parts;
    };
    const fields = new Map([
        ['%N', 'name'],
        ['%O', 'organization'],
        ['%A', 'addressLines'],
        ['%D', 'dependentLocality'],
        ['%C', 'locality'],
        ['%S', 'administrativeArea'],
        ['%Z', 'postalCode'],
        ['%X', 'sortingCode'],
        ['%R', 'postalCountry'],
    ]);
    const getFieldForFormatSubstring = (formatSubstring) => {
        const field = fields.get(formatSubstring);
        /* istanbul ignore next imported format strings should never contain invalid substrings */
        if (!field) {
            throw new Error(`Could not find field for format substring ${formatSubstring}`);
        }
        return field;
    };
    const addressHasValueForField = (address, field) => {
        if (field === 'addressLines') {
            return address.addressLines !== undefined && address.addressLines.length > 0;
        }
        return address[field] !== undefined && address[field] !== '';
    };
    const formatSubstringRepresentsField = (formatSubstring) => {
        return formatSubstring !== '%n' && formatSubstring.startsWith('%');
    };
    const pruneFormat = (formatSubstrings, address) => {
        const prunedFormat = [];
        for (const [i, formatSubstring] of formatSubstrings.entries()) {
            // Always keep the newlines.
            if (formatSubstring === '%n') {
                prunedFormat.push(formatSubstring);
                continue;
            }
            if (formatSubstringRepresentsField(formatSubstring)) {
                // Always keep non-empty address fields.
                if (addressHasValueForField(address, getFieldForFormatSubstring(formatSubstring))) {
                    prunedFormat.push(formatSubstring);
                }
                continue;
            }
            // Only keep literals that satisfy these two conditions:
            // 1. Not preceding an empty field.
            // 2. Not following a removed field.
            if ((i === formatSubstrings.length - 1
                || formatSubstrings[i + 1] === '%n'
                || addressHasValueForField(address, getFieldForFormatSubstring(formatSubstrings[i + 1]))) && (i === 0
                || !formatSubstringRepresentsField(formatSubstrings[i - 1])
                || (prunedFormat.length > 0 && formatSubstringRepresentsField(prunedFormat[prunedFormat.length - 1])))) {
                prunedFormat.push(formatSubstring);
            }
        }
        return prunedFormat;
    };
    const formatAddress = (address, scriptType = 'local') => {
        var _a;
        const formatString = getFormatString((_a = address.postalCountry) !== null && _a !== void 0 ? _a : 'ZZ', scriptType);
        const formatSubstrings = getFormatSubstrings(formatString);
        const prunedFormat = pruneFormat(formatSubstrings, address);
        const lines = [];
        let currentLine = '';
        for (const formatSubstring of prunedFormat) {
            if (formatSubstring === '%n') {
                if (currentLine.length > 0) {
                    lines.push(currentLine);
                    currentLine = '';
                }
                continue;
            }
            if (!formatSubstringRepresentsField(formatSubstring)) {
                // Not a symbol we recognize, so must be a literal. We append it unchanged.
                currentLine += formatSubstring;
                continue;
            }
            const field = getFieldForFormatSubstring(formatSubstring);
            /* istanbul ignore next imported format strings should never contain the postal country */
            if (field === 'postalCountry') {
                // Country name is treated separately.
                continue;
            }
            if (field === 'addressLines') {
                // The field "address lines" represents the address lines of an address, so there can be multiple values.
                // It is safe to assert addressLines to be defined here, as the pruning process already checked for that.
                const addressLines = address.addressLines.filter(addressLine => addressLine !== '');
                if (addressLines.length === 0) {
                    // Empty address lines are ignored.
                    continue;
                }
                currentLine += addressLines[0];
                if (addressLines.length > 1) {
                    lines.push(currentLine);
                    currentLine = '';
                    lines.push(...addressLines.slice(1));
                }
                continue;
            }
            // Any other field can be appended as is.
            currentLine += address[field];
        }
        if (currentLine.length > 0) {
            lines.push(currentLine);
        }
        return lines;
    };

    exports.formatAddress = formatAddress;

    Object.defineProperty(exports, '__esModule', { value: true });

}));

}(index_umd, index_umd.exports));

const scCustomerDetailsCss = "";
const ScCustomerDetailsStyle0 = scCustomerDetailsCss;

const ScCustomerDetails = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.heading = undefined;
        this.editLink = undefined;
        this.customer = undefined;
        this.loading = undefined;
        this.error = undefined;
    }
    renderContent() {
        var _a, _b, _c, _d, _e, _f, _g, _h;
        if (this.loading) {
            return this.renderLoading();
        }
        if (!this.customer) {
            return this.renderEmpty();
        }
        return (index.h("sc-card", { "no-padding": true }, index.h("sc-stacked-list", null, !!((_a = this === null || this === void 0 ? void 0 : this.customer) === null || _a === void 0 ? void 0 : _a.name) && (index.h("sc-stacked-list-row", { style: { '--columns': '3' }, mobileSize: 480 }, index.h("div", null, index.h("strong", null, wp.i18n.__('Billing Name', 'surecart'))), index.h("div", null, (_b = this.customer) === null || _b === void 0 ? void 0 : _b.name), index.h("div", null))), !!((_c = this === null || this === void 0 ? void 0 : this.customer) === null || _c === void 0 ? void 0 : _c.email) && (index.h("sc-stacked-list-row", { style: { '--columns': '3' }, mobileSize: 480 }, index.h("div", null, index.h("strong", null, wp.i18n.__('Billing Email', 'surecart'))), index.h("div", null, (_d = this.customer) === null || _d === void 0 ? void 0 : _d.email), index.h("div", null))), !!Object.keys(((_e = this === null || this === void 0 ? void 0 : this.customer) === null || _e === void 0 ? void 0 : _e.shipping_address) || {}).length && this.renderAddress(wp.i18n.__('Shipping Address', 'surecart'), this.customer.shipping_address), !!Object.keys((_f = this.customer) === null || _f === void 0 ? void 0 : _f.billing_address_display).length && this.renderAddress(wp.i18n.__('Billing Address', 'surecart'), this.customer.billing_address_display), !!((_g = this === null || this === void 0 ? void 0 : this.customer) === null || _g === void 0 ? void 0 : _g.phone) && (index.h("sc-stacked-list-row", { style: { '--columns': '3' }, mobileSize: 480 }, index.h("div", null, index.h("strong", null, wp.i18n.__('Phone', 'surecart'))), index.h("div", null, (_h = this.customer) === null || _h === void 0 ? void 0 : _h.phone), index.h("div", null))), (() => {
            var _a, _b, _c, _d;
            const { number_type, number } = ((_a = this.customer) === null || _a === void 0 ? void 0 : _a.tax_identifier) || {};
            if (!number || !number_type)
                return;
            const label = ((_b = tax.zones === null || tax.zones === void 0 ? void 0 : tax.zones[number_type]) === null || _b === void 0 ? void 0 : _b.label) || wp.i18n.__('Tax Id', 'surecart');
            const isInvalid = ((_d = (_c = this.customer) === null || _c === void 0 ? void 0 : _c.tax_identifier) === null || _d === void 0 ? void 0 : _d[`valid_${number_type}`]) === false;
            return (index.h("sc-stacked-list-row", { style: { '--columns': '3' }, mobileSize: 480 }, index.h("div", null, index.h("strong", null, label)), index.h("div", null, number, " ", isInvalid && index.h("sc-tag", { type: "warning" }, wp.i18n.__('Invalid', 'surecart'))), index.h("div", null)));
        })())));
    }
    renderAddress(label = 'Address', address$1) {
        var _a;
        const { name, line_1, line_2, city, state, postal_code, country } = address$1;
        const countryName = (_a = address.countryChoices.find(({ value }) => value === country)) === null || _a === void 0 ? void 0 : _a.label;
        return (index.h("sc-stacked-list-row", { style: { '--columns': '3' }, mobileSize: 480 }, index.h("div", null, index.h("strong", null, label)), index.h("div", null, [
            ...(index_umd.exports.formatAddress({
                name: name || '',
                postalCountry: country || '',
                administrativeArea: state || '',
                locality: city || '',
                postalCode: postal_code || '',
                addressLines: [line_1, line_2].filter(Boolean),
            }) || []),
            countryName || country,
        ].join('\n')), index.h("div", null)));
    }
    renderEmpty() {
        return (index.h("div", null, index.h("sc-divider", { style: { '--spacing': '0' } }), index.h("slot", { name: "empty" }, index.h("sc-empty", { icon: "user" }, wp.i18n.__("You don't have any billing information.", 'surecart')))));
    }
    renderLoading() {
        return (index.h("sc-card", { "no-padding": true }, index.h("sc-stacked-list", null, index.h("sc-stacked-list-row", { style: { '--columns': '2' }, "mobile-size": 0 }, index.h("div", { style: { padding: '0.5em' } }, index.h("sc-skeleton", { style: { width: '30%', marginBottom: '0.75em' } }), index.h("sc-skeleton", { style: { width: '20%', marginBottom: '0.75em' } }), index.h("sc-skeleton", { style: { width: '40%' } }))))));
    }
    render() {
        var _a, _b, _c;
        return (index.h("sc-dashboard-module", { key: 'f3fbf9ef489ac0e77ade16edfbdb1eea0649e074', exportparts: "base, heading, heading-text, heading-title, heading-description", class: "customer-details", error: this.error }, index.h("span", { key: '88f74c9c5177f635154fc8f8ab0f9b03ec4ec19e', slot: "heading" }, this.heading || wp.i18n.__('Billing Details', 'surecart'), ' ', !!((_a = this === null || this === void 0 ? void 0 : this.customer) === null || _a === void 0 ? void 0 : _a.id) && !((_b = this === null || this === void 0 ? void 0 : this.customer) === null || _b === void 0 ? void 0 : _b.live_mode) && (index.h("sc-tag", { key: 'f4142873392f61e8939ead67a89da107fb92e448', exportparts: "base:test-tag__base, content:test-tag__content", type: "warning", size: "small" }, wp.i18n.__('Test', 'surecart')))), !!this.editLink && !!((_c = this.customer) === null || _c === void 0 ? void 0 : _c.id) && (index.h("sc-button", { key: 'ee72a52953f117c7dca3eee3496b46ec35112303', exportparts: "base:button__base, label:button__label, prefix:button__prefix", type: "link", href: this.editLink, slot: "end" }, index.h("sc-icon", { key: 'a6c4e1a4e1b8e835471b234c6b0e15c682cb9ce2', name: "edit-3", slot: "prefix" }), wp.i18n.__('Update', 'surecart'))), this.renderContent()));
    }
    get el() { return index.getElement(this); }
};
ScCustomerDetails.style = ScCustomerDetailsStyle0;

exports.sc_customer_details = ScCustomerDetails;

//# sourceMappingURL=sc-customer-details.cjs.entry.js.map