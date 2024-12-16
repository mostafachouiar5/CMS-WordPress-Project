'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const index$1 = require('./index-21f8920e.js');

const ScLineItemsProvider = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.scUpdateLineItems = index.createEvent(this, "scUpdateLineItems", 7);
        this.order = undefined;
        this.syncItems = [];
    }
    /** Handle line item toggle */
    handleLineItemToggle(e) {
        const lineItem = e.detail;
        this.addSyncItem('toggle', lineItem);
    }
    /** Handle line item remove */
    handleLineItemRemove(e) {
        const lineItem = e.detail;
        this.addSyncItem('remove', lineItem);
    }
    /** Handle line item add */
    handleLineItemAdd(e) {
        const lineItem = e.detail;
        this.addSyncItem('add', lineItem);
    }
    /** Handle line item add */
    handleLineItemUpdate(e) {
        const lineItem = e.detail;
        this.addSyncItem('update', lineItem);
    }
    /** We listen to the syncItems array and run it on the next render in batch */
    async syncItemsHandler(val) {
        if (!(val === null || val === void 0 ? void 0 : val.length))
            return;
        setTimeout(() => {
            var _a;
            if (!((_a = this.syncItems) === null || _a === void 0 ? void 0 : _a.length))
                return;
            const items = this.processSyncItems();
            this.scUpdateLineItems.emit(items);
            this.syncItems = [];
        }, 100);
    }
    /** Add item to sync */
    addSyncItem(type, payload) {
        this.syncItems = [...this.syncItems, ...[{ type, payload }]];
    }
    /** Batch process items to sync before sending */
    processSyncItems() {
        var _a;
        // get existing line item data.
        let existingData = index$1.convertLineItemsToLineItemData(((_a = this === null || this === void 0 ? void 0 : this.order) === null || _a === void 0 ? void 0 : _a.line_items) || []);
        const map = {
            toggle: this.toggleItem,
            add: this.addItem,
            remove: this.removeItem,
            update: this.updateItem,
        };
        // run existing data through chain of sync updates.
        (this.syncItems || []).forEach(item => {
            existingData = map[item.type](item.payload, existingData);
        });
        return existingData;
    }
    /** Add item */
    addItem(item, existingLineData) {
        return [...existingLineData, ...[item]];
    }
    /** Toggle item */
    toggleItem(item, existingLineData) {
        var _a;
        // find existing item.
        const existingPriceId = (_a = existingLineData.find(line => line.price_id === item.price_id)) === null || _a === void 0 ? void 0 : _a.price_id;
        // toggle it.
        existingLineData = existingPriceId ? existingLineData.filter(item => existingPriceId !== item.price_id) : [...existingLineData, ...[item]];
        // return.
        return existingLineData;
    }
    /** Remove item */
    removeItem(item, existingLineData) {
        if (!item.price_id)
            return existingLineData;
        return existingLineData.filter(data => data.price_id !== item.price_id);
    }
    /** Update the item item */
    updateItem(item, existingLineData) {
        // find existing item.
        const existingLineItem = existingLineData.findIndex(line => line.price_id === item.price_id);
        // if we found it, update it
        if (existingLineItem !== -1) {
            existingLineData[existingLineItem] = item;
            // otherwise, add it
        }
        else {
            return [...existingLineData, ...[item]];
        }
        return existingLineData;
    }
    render() {
        return index.h("slot", { key: 'c52582c8cb4ba6030b71e372bc85f0031376f8eb' });
    }
    static get watchers() { return {
        "syncItems": ["syncItemsHandler"]
    }; }
};

exports.sc_line_items_provider = ScLineItemsProvider;

//# sourceMappingURL=sc-line-items-provider.cjs.entry.js.map