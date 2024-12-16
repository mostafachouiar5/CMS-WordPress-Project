import { r as registerInstance, c as createEvent, h, a as getElement } from './index-745b6bec.js';

/**
 * Serializes a form and returns a plain object. If a form control with the same name appears more than once, the
 * property will be converted to an array.
 */
function serialize(form) {
    const formData = new FormData(form);
    const object = {};
    formData.forEach((value, key) => {
        object[key] = value;
    });
    return object;
}

const scFormCss = ":host{display:block}::slotted(*:not(:last-child)){margin-bottom:var(--sc-form-row-spacing, 0.75em)}::slotted(*:not(:last-child)).wp-block-spacer{margin-bottom:0}::slotted(*:focus-within),::slotted(*:active){position:relative;z-index:var(--sc-form-focus-within-z-index, auto);}";
const ScFormStyle0 = scFormCss;

const ScForm = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.scSubmit = createEvent(this, "scSubmit", 7);
        this.scFormSubmit = createEvent(this, "scFormSubmit", 7);
        this.scFormChange = createEvent(this, "scFormChange", 7);
        this.novalidate = false;
    }
    /** Serializes all form controls elements and returns a `FormData` object. */
    async getFormData() {
        return new FormData(this.formElement);
    }
    async getFormJson() {
        return serialize(this.formElement);
    }
    async handleChange() {
        this.scFormChange.emit(serialize(this.formElement));
    }
    async submit() {
        return this.submitForm();
    }
    /** Gets all form control elements (native and custom). */
    getFormControls() {
        return [...this.form.querySelectorAll('*')];
    }
    async validate() {
        const formControls = this.getFormControls();
        const formControlsThatReport = formControls.filter((el) => typeof el.reportValidity === 'function');
        if (!this.novalidate) {
            for (const el of formControlsThatReport) {
                // element is hidden, don't client-side validate.
                if (!(el.offsetWidth || el.offsetHeight || el.getClientRects().length)) {
                    continue;
                }
                const isValid = await el.reportValidity();
                if (!isValid) {
                    return false;
                }
            }
        }
        return true;
    }
    submitForm() {
        // Calling form.submit() seems to bypass the submit event and constraint validation. Instead, we can inject a
        // native submit button into the form, click it, then remove it to simulate a standard form submission.
        const button = document.createElement('button');
        if (this.formElement) {
            button.type = 'submit';
            button.style.position = 'absolute';
            button.style.width = '0';
            button.style.height = '0';
            button.style.clip = 'rect(0 0 0 0)';
            button.style.clipPath = 'inset(50%)';
            button.style.overflow = 'hidden';
            button.style.whiteSpace = 'nowrap';
            this.formElement.append(button);
            button.click();
            button.remove();
        }
    }
    render() {
        return (h("div", { key: 'a013706193246ca9488d0310a5d8f8e49c2c0bcc', part: "base", class: "form", role: "form" }, h("form", { key: '99ffcdf1b5fa5e2457de18145818025e49010fc9', part: "form", ref: el => (this.formElement = el), class: "test", onSubmit: async (e) => {
                e.preventDefault();
                const isValid = await this.validate();
                if (!isValid) {
                    return false;
                }
                this.scSubmit.emit();
                this.scFormSubmit.emit();
            }, novalidate: this.novalidate }, h("slot", { key: '97b057251255efeaade0529b341594fcf4f60804' }))));
    }
    get form() { return getElement(this); }
};
ScForm.style = ScFormStyle0;

export { ScForm as sc_form };

//# sourceMappingURL=sc-form.entry.js.map