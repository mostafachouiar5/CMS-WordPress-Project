import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';
import { F as FormSubmitController } from './form-data-76641f16.js';

const scSwitchCss = ":host{--height:var(--sc-toggle-size);--thumb-size:calc(var(--sc-toggle-size) - 2px);--width:calc(var(--height) * 2);display:block}.switch{display:inline-flex;align-items:flex-start;gap:0.7em;font-family:var(--sc-input-font-family);font-size:var(--sc-input-font-size-medium);font-weight:var(--sc-input-font-weight);color:var(--sc-input-color);vertical-align:middle;cursor:pointer}.switch--reversed{flex-direction:row-reverse}.switch--editing{cursor:initial}.switch__control{flex:0 0 auto;position:relative;display:inline-flex;align-items:center;justify-content:center;width:var(--width);height:var(--height);background-color:var(--sc-switch-control-background-color, var(--sc-color-gray-300));border:solid var(--sc-input-border-width) var(--sc-switch-border-color, var(--sc-color-gray-300));border-radius:var(--height);transition:var(--sc-input-transition, var(--sc-transition-medium)) border-color, var(--sc-input-transition, var(--sc-transition-medium)) background-color}.switch__control .switch__thumb{width:var(--thumb-size);height:var(--thumb-size);background-color:var(--sc-switch-thumb-background-color, var(--sc-color-white));border-radius:50%;border:solid var(--sc-input-border-width) var(--sc-input-border-color);transform:translateX(calc(var(--width) / -2 + var(--thumb-size) / 2 - (var(--thumb-size) - var(--height)) / 2));transition:var(--sc-input-transition, var(--sc-transition-medium)) transform ease, var(--sc-input-transition, var(--sc-transition-medium)) background-color, var(--sc-input-transition, var(--sc-transition-medium)) border-color, var(--sc-input-transition, var(--sc-transition-medium)) box-shadow}.switch__control input[type=checkbox]{position:absolute;opacity:0;padding:0;margin:0;pointer-events:none}.switch__control:has(:focus-visible){outline:2px solid var(--sc-focus-ring-color-primary);outline-offset:2px}.switch:not(.switch--checked):not(.switch--disabled) .switch__control:hover{background-color:var(--sc-switch-control-hover-background-color, var(--sc-color-gray-200));border-color:var(--sc-switch-control-hover-border-color, var(--sc-color-gray-200))}.switch:not(.switch--checked):not(.switch--disabled) .switch__control:hover .switch__thumb{background-color:var(--sc-switch-background-thumb-hover-color, var(--sc-color-white));border-color:var(--sc-switch-thumb-border-color, var(--sc-input-border-color))}.switch.switch--focused:not(.switch--checked):not(.switch--disabled) .switch__control{background-color:var(--sc-switch-control-hover-background-color, var(--sc-color-gray-200));border-color:var(--sc-switch-control-hover-border-color, var(--sc-color-gray-200))}.switch.switch--focused:not(.switch--checked):not(.switch--disabled) .switch__control .switch__thumb{background-color:var(--sc-color-white);border-color:var(--sc-color-gray-300);box-shadow:0 0 0 1px var(--sc-color-gray-300)}.switch--checked .switch__control{background-color:var(--sc-switch-checked-control-background-color, var(--sc-color-primary-500));border-color:var(--sc-switch-checked-control-border-color, var(--sc-color-primary-500))}.switch--checked .switch__control .switch__thumb{background-color:var(--sc-color-white);border-color:var(--sc-color-primary-500);transform:translateX(calc(var(--width) / 2 - var(--thumb-size) / 2 + (var(--thumb-size) - var(--height)) / 2))}.switch.switch--checked:not(.switch--disabled) .switch__control:hover{opacity:0.8}.switch.switch--checked:not(.switch--disabled) .switch__control:hover .switch__thumb{background-color:var(--sc-color-white);border-color:var(--sc-color-primary-500)}.switch.switch--checked:not(.switch--disabled).switch--focused .switch__control .switch__thumb{background-color:var(--sc-color-white);border-color:var(--sc-color-primary-500);box-shadow:0 0 0 1px var(--sc-focus-ring-color-primary)}.switch--disabled{opacity:0.5;cursor:not-allowed}.switch__label{user-select:none;line-height:var(--height)}.switch--is-required .switch__title:after{content:\" *\";color:var(--sc-color-danger-500)}.switch__title{color:var(--sc-swith-label-color, var(--sc-input-label-color));font-weight:var(--sc-input-label-font-weight);font-size:var(--sc-input-label-font-size-medium)}.switch__description{display:none;color:var(--sc-switch-description-color, var(--sc-color-gray-500));line-height:var(--sc-line-height-dense);margin:0.5em 0 0;font-size:var(--sc-font-size-small)}.switch--has-description .switch__description{display:block}slot[name=description]::slotted(*){margin:0.75em 0;line-height:var(--sc-line-height-dense);vertical-align:center}";
const ScSwitchStyle0 = scSwitchCss;

let id = 0;
const ScSwitch = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scBlur = createEvent(this, "scBlur", 7);
        this.scChange = createEvent(this, "scChange", 7);
        this.scFocus = createEvent(this, "scFocus", 7);
        this.switchId = `switch-${++id}`;
        this.labelId = `switch-label-${id}`;
        this.hasDescription = undefined;
        this.hasFocus = false;
        this.name = undefined;
        this.value = undefined;
        this.disabled = false;
        this.required = false;
        this.checked = false;
        this.invalid = false;
        this.reversed = undefined;
        this.edit = false;
    }
    /** Checks for validity and shows the browser's validation message if the control is invalid. */
    async reportValidity() {
        this.invalid = !this.input.checkValidity();
        return this.input.reportValidity();
    }
    handleClick() {
        this.checked = !this.checked;
        this.scChange.emit();
    }
    handleBlur() {
        this.hasFocus = false;
        this.scBlur.emit();
    }
    handleFocus() {
        this.hasFocus = true;
        this.scFocus.emit();
    }
    handleKeyDown(event) {
        if (this.edit)
            return true;
        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            this.checked = false;
            this.scChange.emit();
        }
        if (event.key === 'ArrowRight') {
            event.preventDefault();
            this.checked = true;
            this.scChange.emit();
        }
        if (event.key === ' ' || event.key === 'Enter') {
            event.preventDefault();
            this.handleClick();
        }
    }
    handleMouseDown(event) {
        if (this.edit)
            return true;
        // Prevent clicks on the label from briefly blurring the input
        event.preventDefault();
        this.input.focus();
    }
    handleCheckedChange() {
        if (this.input) {
            this.input.checked = this.checked;
            this.invalid = !this.input.checkValidity();
        }
    }
    componentDidLoad() {
        this.formController = new FormSubmitController(this.el, {
            value: (control) => (control.checked ? control.value : undefined),
        }).addFormData();
        this.hasDescription = !!this.el.querySelector('[slot="description"]');
    }
    disconnectedCallback() {
        var _a;
        (_a = this.formController) === null || _a === void 0 ? void 0 : _a.removeFormData();
    }
    render() {
        const Tag = this.edit ? 'div' : 'label';
        return (h(Tag, { key: '153d6ac11130c5d1d98e05c20fa15b1230fa0909', part: "base", htmlFor: this.switchId, class: {
                'switch': true,
                'switch--is-required': this.required,
                'switch--checked': this.checked,
                'switch--disabled': this.disabled,
                'switch--focused': this.hasFocus,
                'switch--reversed': this.reversed,
                'switch--editing': this.edit,
                'switch--has-description': this.hasDescription,
            }, onMouseDown: e => this.handleMouseDown(e) }, h("span", { key: '5cd2a0c7970cb25590e5b893c398e4b7e6e4d270', part: "control", class: "switch__control" }, h("span", { key: '12e3bec55e8ce04e6720626ad044373b231ec610', part: "thumb", class: "switch__thumb" }), h("input", { key: '20faacfafc2e60ee8acd3676f36a50eb586421ed', ref: el => (this.input = el), id: this.switchId, type: "checkbox", role: "switch", name: this.name, value: this.value || 'on', checked: this.checked, disabled: this.disabled, required: this.required, "aria-checked": this.checked ? 'true' : 'false', "aria-labelledby": this.labelId, onClick: () => this.handleClick(), onBlur: () => this.handleBlur(), onFocus: () => this.handleFocus(), onKeyDown: e => this.handleKeyDown(e) })), h("span", { key: 'bb867ecca7b3428139eabde5a2be4e128070512d', class: "switch__label" }, h("span", { key: '4b252d5f8206cd0d5ec59cb30d6ac085774953e5', part: "title", id: this.labelId, class: "switch__title" }, h("slot", { key: '0ef7bc9d7bdccddd6c0e523601b70737a28ce617' })), h("span", { key: '9034c6502183a8cc288e5587839232dc4618b0a8', class: "switch__description", part: "description" }, h("slot", { key: 'f44b39e6b4081e05134da3e3547bf6a65350d7b4', name: "description" })))));
    }
    get el() { return getElement(this); }
    static get watchers() { return {
        "checked": ["handleCheckedChange"]
    }; }
};
ScSwitch.style = ScSwitchStyle0;

export { ScSwitch as sc_switch };

//# sourceMappingURL=sc-switch.entry.js.map