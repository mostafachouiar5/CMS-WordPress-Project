import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';

const scTabGroupCss = ":host{display:block;--sc-tabs-min-width:225px}.tab-group{display:flex;flex-wrap:wrap;position:relative;border:solid 1px transparent;border-radius:0;flex-direction:row}@media screen and (min-width: 750px){.tab-group{flex-wrap:nowrap}}.tab-group__tabs{display:flex;flex-wrap:wrap;flex:0 0 auto;flex-direction:column;margin-bottom:var(--sc-spacing-xx-large)}.tab-group__nav-container{order:1;flex:1 0 100%}@media screen and (min-width: 750px){.tab-group__nav-container{min-width:var(--sc-tabs-min-width);flex:0 1 auto}}.tab-group__body{flex:1 1 auto;order:2}@media screen and (min-width: 750px){.tab-group__body{padding:0 var(--sc-spacing-xx-large)}}::slotted(sc-tab){margin-bottom:var(--sc-spacing-xx-small)}";
const ScTabGroupStyle0 = scTabGroupCss;

const ScTabGroup = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scTabHide = createEvent(this, "scTabHide", 7);
        this.scTabShow = createEvent(this, "scTabShow", 7);
        this.tabs = [];
        this.panels = [];
        this.activeTab = undefined;
    }
    componentDidLoad() {
        this.syncTabsAndPanels();
        this.setAriaLabels();
        this.setActiveTab(this.getActiveTab() || this.tabs[0], { emitEvents: false });
        this.mutationObserver = new MutationObserver(() => {
            this.syncTabsAndPanels();
        });
        this.mutationObserver.observe(this.el, { attributes: true, childList: true, subtree: true });
    }
    disconnectedCallback() {
        this.mutationObserver.disconnect();
    }
    syncTabsAndPanels() {
        this.tabs = this.getAllTabs();
        this.panels = this.getAllPanels();
    }
    setAriaLabels() {
        // Link each tab with its corresponding panel
        this.tabs.map(tab => {
            const panel = this.panels.find(el => el.name === tab.panel);
            if (panel) {
                tab.setAttribute('aria-controls', panel.getAttribute('id'));
                panel.setAttribute('aria-labelledby', tab.getAttribute('id'));
            }
        });
    }
    handleClick(event) {
        const target = event.target;
        const tab = target.closest('sc-tab');
        const tabGroup = tab === null || tab === void 0 ? void 0 : tab.closest('sc-tab-group');
        // Ensure the target tab is in this tab group
        if (tabGroup !== this.el) {
            return;
        }
        if (tab) {
            this.setActiveTab(tab, { scrollBehavior: 'smooth' });
        }
    }
    handleKeyDown(event) {
        const target = event.target;
        const tab = target.closest('sc-tab');
        const tabGroup = tab === null || tab === void 0 ? void 0 : tab.closest('sc-tab-group');
        // Ensure the target tab is in this tab group
        if (tabGroup !== this.el) {
            return true;
        }
        // Activate a tab
        if (['Enter', ' '].includes(event.key)) {
            if (tab) {
                this.setActiveTab(tab, { scrollBehavior: 'smooth' });
            }
        }
        // Move focus left or right
        if (['ArrowUp', 'ArrowDown', 'Home', 'End'].includes(event.key)) {
            const activeEl = document.activeElement;
            if (activeEl && activeEl.tagName.toLowerCase() === 'sc-tab') {
                let index = this.tabs.indexOf(activeEl);
                if (event.key === 'Home') {
                    index = 0;
                }
                else if (event.key === 'End') {
                    index = this.tabs.length - 1;
                }
                else if (event.key === 'ArrowUp') {
                    index = Math.max(0, index - 1);
                }
                else if (event.key === 'ArrowDown') {
                    index = Math.min(this.tabs.length - 1, index + 1);
                }
                this.tabs[index].triggerFocus({ preventScroll: true });
                event.preventDefault();
            }
        }
    }
    /** Handle the active tabl selection */
    setActiveTab(tab, options) {
        options = Object.assign({
            emitEvents: true,
            scrollBehavior: 'auto',
        }, options);
        if (tab && tab !== this.activeTab && !tab.disabled) {
            const previousTab = this.activeTab;
            this.activeTab = tab;
            this.tabs.map(el => (el.active = el === this.activeTab));
            this.panels.map(el => (el.active = el.name === this.activeTab.panel));
            // Emit events
            if (options.emitEvents) {
                if (previousTab) {
                    this.scTabHide.emit(previousTab.panel);
                }
                this.scTabShow.emit(this.activeTab.panel);
            }
        }
    }
    getActiveTab() {
        const tabs = this.getAllTabs();
        return tabs.find(el => el.active);
    }
    getAllChildren() {
        const slots = this.el.shadowRoot.querySelectorAll('slot');
        const tags = ['sc-tab', 'sc-tab-panel'];
        const allSlots = Array.from(slots)
            .map(slot => { var _a; return (_a = slot === null || slot === void 0 ? void 0 : slot.assignedElements) === null || _a === void 0 ? void 0 : _a.call(slot, { flatten: true }); })
            .flat();
        return allSlots
            .reduce((all, el) => { var _a; return all.concat(el, [...(((_a = el === null || el === void 0 ? void 0 : el.querySelectorAll) === null || _a === void 0 ? void 0 : _a.call(el, '*')) || [])]); }, [])
            .filter((el) => { var _a, _b; return tags.includes((_b = (_a = el === null || el === void 0 ? void 0 : el.tagName) === null || _a === void 0 ? void 0 : _a.toLowerCase) === null || _b === void 0 ? void 0 : _b.call(_a)); });
    }
    /** Get all child tabs */
    getAllTabs(includeDisabled = false) {
        return this.getAllChildren().filter((el) => {
            return includeDisabled ? el.tagName.toLowerCase() === 'sc-tab' : el.tagName.toLowerCase() === 'sc-tab' && !el.disabled;
        });
    }
    /** Get all child panels */
    getAllPanels() {
        return this.getAllChildren().filter((el) => el.tagName.toLowerCase() === 'sc-tab-panel');
    }
    render() {
        return (h("div", { key: '4615c84a4e03e38e71f17d18ee83c881c3fa270e', part: "base", class: {
                'tab-group': true,
            }, onClick: e => this.handleClick(e), onKeyDown: e => this.handleKeyDown(e) }, h("div", { key: '129980bb4d68e7d3234ca8f0c538ecf88b072a64', class: "tab-group__nav-container", part: "nav" }, h("div", { key: '5732db586ad42f62d019a67c72e5ca012a0a3899', class: "tab-group__nav" }, h("div", { key: 'e74e2bd5e5edd8ddb55b2b889e2d9fdcd3a134d8', part: "tabs", class: "tab-group__tabs", role: "tablist" }, h("slot", { key: 'e911d6c40c8c0d08fa8e2bbc161e65e4ada1d807', onSlotchange: () => this.syncTabsAndPanels(), name: "nav" })))), h("div", { key: '17ef1d5e0e4007acfc2d807be1fe3aa322b9dd99', part: "body", class: "tab-group__body" }, h("slot", { key: 'c8e6d80081395a64b853810e0fb5a68a48552343', onSlotchange: () => this.syncTabsAndPanels() }))));
    }
    get el() { return getElement(this); }
};
ScTabGroup.style = ScTabGroupStyle0;

export { ScTabGroup as sc_tab_group };

//# sourceMappingURL=sc-tab-group.entry.js.map