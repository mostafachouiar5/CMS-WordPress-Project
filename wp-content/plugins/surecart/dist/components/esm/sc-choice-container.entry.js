import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';
import { F as FormSubmitController } from './form-data-76641f16.js';
import { i as isRtl } from './page-align-0cdacf32.js';

const scChoiceContainerCss = ":host{display:flex;flex-direction:column;align-items:stretch;justify-content:stretch;min-width:0;align-self:stretch;height:100%}[hidden]{border:0 !important;clip:rect(0 0 0 0) !important;height:1px !important;margin:-1px !important;overflow:hidden !important;padding:0 !important;position:absolute !important;width:1px !important}.choice{background:var(--sc-choice-background-color);font-family:var(--sc-input-font-family);font-size:var(--sc-input-font-size-medium);font-weight:var(--sc-input-font-weight);user-select:none;border:solid var(--sc-choice-border-width, var(--sc-input-border-width)) var(--sc-choice-border-color, var(--sc-input-border-color));border-radius:var(--sc-choice-border-radius, var(--sc-input-border-radius-large));box-shadow:var(--sc-choice-box-shadow);cursor:pointer;padding:var(--sc-choice-padding-top, 1.3em) var(--sc-choice-padding-right, 1.1em) var(--sc-choice-padding-bottom, 1.3em) var(--sc-choice-padding-left, 1.1em);position:relative;text-decoration:none;color:var(--sc-choice-text-color, var(--sc-input-color));height:100%;transition:background-color 150ms ease, border-color 150ms ease, color 150ms ease, box-shadow 150ms ease;box-sizing:border-box}.choice--is-rtl{text-align:right}.choice__content{cursor:pointer;display:flex;align-items:center;gap:0.75em;height:100%}.choice--checked{border-color:var(--sc-color-primary-500);box-shadow:0 0 0 1px var(--sc-color-primary-500);z-index:1}.choice__title{display:inline-block;font-weight:var(--sc-input-label-font-weight);font-size:var(--sc-input-label-font-size-medium)}.choice--size-small{padding:0.75em 0.9em}.choice--size-large{padding:1.3em 1.1em}.choice__icon{display:inline-flex;width:var(--sc-radio-size);height:var(--sc-radio-size)}.choice__icon svg{width:100%;height:100%}.choice__control{flex:0 0 auto;position:relative;display:inline-flex;align-items:center;justify-content:center;border:solid var(--sc-input-border-width) var(--sc-input-border-color);background-color:var(--sc-input-background-color);color:transparent;transition:var(--sc-input-transition, var(--sc-transition-medium)) border-color, var(--sc-input-transition, var(--sc-transition-medium)) background-color, var(--sc-input-transition, var(--sc-transition-medium)) color, var(--sc-input-transition, var(--sc-transition-medium)) box-shadow}.choice__control.choice__radio{width:var(--sc-radio-size);height:var(--sc-radio-size);border-radius:50%}.choice__control.choice__checkbox{width:var(--sc-toggle-size);height:var(--sc-toggle-size);border-radius:4px}.choice__control input[type=radio],.choice__control input[type=checkbox]{position:absolute;opacity:0;padding:0;margin:0;pointer-events:none}.choice:not(.choice--checked):not(.choice--disabled) .choice__control:hover{border-color:var(--sc-input-border-color-hover);background-color:var(--sc-input-background-color-hover)}.choice.choice--focused:not(.choice--checked):not(.choice--disabled) .choice__control{border-color:var(--var-sc-checked-focus-border-color, var(--sc-input-background-color));background-color:var(--sc-input-background-color-focus);box-shadow:0 0 0 var(--sc-focus-ring-width) var(--sc-color-primary-500)}.choice.choice--focused:not(.choice--checked):not(.choice--disabled){outline-style:solid;outline-color:var(--sc-color-primary-500);outline-width:var(--sc-focus-ring-width);outline-offset:2px}.choice--checked .choice__control{color:var(--var-sc-checked-color, var(--sc-input-background-color));border-color:var(--sc-color-primary-500);background-color:var(--sc-color-primary-500)}.choice.choice--checked:not(.choice--disabled) .choice__control:hover{border-color:var(--var-sc-checked-hover-radio-border-color, var(--sc-input-background-color));background-color:var(--sc-color-primary-500)}.choice.choice--checked:not(.choice--disabled).choice--focused .choice__control{border-color:var(--var-sc-checked-focus-radio-border-color, var(--sc-input-background-color));background-color:var(--sc-color-primary-500);box-shadow:0 0 0 var(--sc-focus-ring-width) var(--sc-focus-ring-color-primary)}.choice--disabled{opacity:0.5;cursor:not-allowed}.choice:not(.choice--checked) svg circle{opacity:0}.choice__label{width:100%;line-height:1;user-select:none}.choice--layout-columns .choice__label{display:flex;justify-content:space-between;flex-wrap:wrap;gap:0.5em}.choice--layout-columns .choice__price{text-align:right;margin:0;display:flex;flex-direction:column;gap:var(--sc-spacing-xx-small)}.choice__description{display:inline-block;color:var(--sc-color-gray-500);font-size:var(--sc-font-size-medium)}.choice__label-text{display:flex;flex-direction:column;justify-content:center;gap:0.2em;flex:1}.choice__price{display:block}";
const ScChoiceContainerStyle0 = scChoiceContainerCss;

let id = 0;
const ScChoiceContainer = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scBlur = createEvent(this, "scBlur", 7);
        this.scChange = createEvent(this, "scChange", 7);
        this.scFocus = createEvent(this, "scFocus", 7);
        this.inputId = `choice-container-${++id}`;
        this.labelId = `choice-container-label-${id}`;
        this.hasFocus = false;
        this.name = undefined;
        this.size = 'medium';
        this.value = undefined;
        this.type = 'radio';
        this.disabled = false;
        this.checked = false;
        this.required = false;
        this.invalid = false;
        this.showControl = true;
        this.role = undefined;
    }
    /** Simulates a click on the choice. */
    async triggerClick() {
        this.input.click();
    }
    async triggerFocus() {
        this.input.focus();
    }
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    async reportValidity() {
        this.invalid = !this.input.checkValidity();
        if (this.required) {
            const choices = this.getAllChoices();
            if (!choices.some(c => c.checked)) {
                this.input.setCustomValidity(this.type === 'radio' ? wp.i18n.__('Please choose one.', 'surecart') : wp.i18n.__('Please choose at least one.', 'surecart'));
                this.invalid = !this.input.checkValidity();
            }
            else {
                this.input.setCustomValidity('');
                this.invalid = !this.input.checkValidity();
            }
        }
        return this.input.reportValidity();
    }
    handleCheckedChange() {
        this.input.setCustomValidity('');
        if (this.type === 'radio' && this.checked) {
            this.getSiblingChoices().map(choice => (choice.checked = false));
        }
        this.input.checked = this.checked;
    }
    handleBlur() {
        this.hasFocus = false;
        this.scBlur.emit();
    }
    handleFocus() {
        this.hasFocus = true;
        this.scFocus.emit();
    }
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    async setCustomValidity(message) {
        this.input.setCustomValidity(message);
        this.invalid = !this.input.checkValidity();
    }
    getAllChoices() {
        const choiceGroup = this.el.closest('sc-choices') || this.el.parentElement;
        // Radios must be part of a radio group
        if (!choiceGroup) {
            return [];
        }
        return [...choiceGroup.querySelectorAll('sc-choice-container, sc-choice')];
    }
    getSiblingChoices() {
        return this.getAllChoices().filter(choice => choice !== this.el);
    }
    handleKeyDown(event) {
        if (event.target.contentEditable === 'true')
            return;
        // On arrow key press.
        if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(event.key)) {
            const choices = this.getAllChoices().filter(choice => !choice.disabled);
            const incr = ['ArrowUp', 'ArrowLeft'].includes(event.key) ? -1 : 1;
            let index = choices.indexOf(this.el) + incr;
            if (index < 0)
                index = choices.length - 1;
            if (index > choices.length - 1)
                index = 0;
            choices[index].triggerFocus();
            choices[index].checked = true;
            event.preventDefault();
        }
        // On space key press select the choice like handle mouse click.
        if (event.key === ' ') {
            event.preventDefault();
            this.checked = true;
            this.scChange.emit(this.input.checked);
        }
    }
    componentDidLoad() {
        this.formController = new FormSubmitController(this.el, {
            value: (control) => (control.checked ? control.value : undefined),
        }).addFormData();
    }
    disconnectedCallback() {
        var _a;
        (_a = this.formController) === null || _a === void 0 ? void 0 : _a.removeFormData();
    }
    handleClickEvent() {
        if (this.type === 'checkbox') {
            this.checked = !this.checked;
            this.scChange.emit(this.input.checked);
        }
        else if (!this.checked) {
            this.checked = true;
            this.scChange.emit(this.input.checked);
        }
    }
    render() {
        return (h("div", { key: '77d6fb9d20fd772e4b2285b69c52c222d22ef092', part: "base", class: {
                'choice': true,
                'choice--checked': this.checked,
                'choice--disabled': this.disabled,
                'choice--focused': this.hasFocus,
                'choice--is-rtl': isRtl(),
                [`choice--size-${this.size}`]: true,
            }, role: "radio", "aria-checked": this.checked ? 'true' : 'false', "aria-disabled": this.disabled ? 'true' : 'false', onKeyDown: e => this.handleKeyDown(e) }, h("slot", { key: '101cfc39748136ba55dbee171804db93baa78bf6', name: "header" }), h("div", { key: '68cfa1b7394ae4800329dd1cc0893d1af0149e30', class: "choice__content", part: "content" }, h("span", { key: 'fa4f61f13df55cd900ea393dd77ba00a224f6c4a', part: "control", class: {
                choice__control: true,
                choice__checkbox: this.type === 'checkbox',
                choice__radio: this.type === 'radio',
            }, hidden: !this.showControl }, h("span", { key: '2500e5d5f6133defdd37bf83005615bec88e1b4f', part: "checked-icon", class: "choice__icon" }, this.type === 'checkbox' ? (h("svg", { viewBox: "0 0 16 16" }, h("g", { stroke: "none", "stroke-width": "1", fill: "none", "fill-rule": "evenodd", "stroke-linecap": "round" }, h("g", { stroke: "currentColor", "stroke-width": "2" }, h("g", { transform: "translate(3.428571, 3.428571)" }, h("path", { d: "M0,5.71428571 L3.42857143,9.14285714" }), h("path", { d: "M9.14285714,0 L3.42857143,9.14285714" })))))) : (h("svg", { viewBox: "0 0 16 16" }, h("g", { stroke: "none", "stroke-width": "1", fill: "none", "fill-rule": "evenodd" }, h("g", { fill: "currentColor" }, h("circle", { cx: "8", cy: "8", r: "3.42857143" })))))), h("input", { key: 'a332bef15f7cfc702f802b89f0abca997853bdb3', id: this.inputId, ref: el => (this.input = el), type: this.type, name: this.name, value: this.value, checked: this.checked, disabled: this.disabled, "aria-checked": this.checked ? 'true' : 'false', "aria-disabled": this.disabled ? 'true' : 'false', "aria-labelledby": this.labelId, tabindex: "0",
            // required={this.required}
            onBlur: () => this.handleBlur(), onFocus: () => this.handleFocus(), onChange: () => this.handleClickEvent(), role: this.role })), h("label", { key: 'a70d774a37d07a4a82929c200cf0e66cdd732b31', part: "label", id: this.labelId, class: "choice__label" }, h("slot", { key: 'c53a4e8e218862392f25c716b6e7afc2c75c5eb7' })))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "checked": ["handleCheckedChange"]
    }; }
};
ScChoiceContainer.style = ScChoiceContainerStyle0;

export { ScChoiceContainer as sc_choice_container };

//# sourceMappingURL=sc-choice-container.entry.js.map