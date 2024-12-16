import { r as registerInstance, h, a as getElement } from './index-745b6bec.js';

const scButtonGroupCss = ":host{display:inline-block;--gap:var(--sc-spacing-small)}.button-group{display:flex;flex-wrap:wrap}.button-group--separate{gap:var(--gap)}";
const ScButtonGroupStyle0 = scButtonGroupCss;

const ScButtonGroup = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.label = undefined;
        this.separate = undefined;
    }
    findButton(el) {
        return ['sc-button'].includes(el.tagName.toLowerCase()) ? el : el.querySelector(['sc-button'].join(','));
    }
    handleFocus(event) {
        const button = this.findButton(event.target);
        button === null || button === void 0 ? void 0 : button.classList.add('sc-button-group__button--focus');
    }
    handleBlur(event) {
        const button = this.findButton(event.target);
        button === null || button === void 0 ? void 0 : button.classList.remove('sc-button-group__button--focus');
    }
    handleMouseOver(event) {
        const button = this.findButton(event.target);
        button === null || button === void 0 ? void 0 : button.classList.add('sc-button-group__button--hover');
    }
    handleMouseOut(event) {
        const button = this.findButton(event.target);
        button === null || button === void 0 ? void 0 : button.classList.remove('sc-button-group__button--hover');
    }
    handleSlotChange() {
        if (this.separate)
            return;
        const slottedElements = this.el.shadowRoot.querySelector('slot').assignedElements({ flatten: true });
        slottedElements.forEach((el) => {
            const slotted = this.el.shadowRoot.querySelector('slot');
            const index = slotted.assignedNodes().indexOf(el);
            const button = this.findButton(el);
            if (button !== null || !this.separate) {
                button.classList.add('sc-button-group__button');
                button.classList.toggle('sc-button-group__button--first', index === 0);
                button.classList.toggle('sc-button-group__button--inner', index > 0 && index < slottedElements.length - 1);
                button.classList.toggle('sc-button-group__button--last', index === slottedElements.length - 1);
            }
        });
    }
    render() {
        return (h("sc-form-control", { key: 'f919642c282c7a6efe674321c25964e917909d17', part: "base", class: {
                'button-group': true,
                'button-group--separate': this.separate,
            }, role: "group", "aria-label": this.label, onFocusout: e => this.handleBlur(e), onFocusin: e => this.handleFocus(e), onMouseOver: e => this.handleMouseOver(e), onMouseOut: e => this.handleMouseOut(e), label: this.label }, h("slot", { key: 'ed7e141319513481169a5dba1fbe890938b5e9d1', onSlotchange: () => this.handleSlotChange() })));
    }
    get el() { return getElement(this); }
};
ScButtonGroup.style = ScButtonGroupStyle0;

export { ScButtonGroup as sc_button_group };

//# sourceMappingURL=sc-button-group.entry.js.map