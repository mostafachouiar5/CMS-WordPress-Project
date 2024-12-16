import { EventEmitter } from '../../../stencil-public-runtime';
import { ChoiceItem } from '../../../types';
/**
 * @part base - The elements base wrapper.
 * @part input - The html input element.
 * @part form-control - The form control wrapper.
 * @part label - The input label.
 * @part help-text - Help text that describes how to use the input.
 * @part trigger - The trigger for the dropdown.
 * @part panel - Them panel for the dropdown.
 * @part caret - The caret.
 * @part search___base - The search base wrapper.
 * @part search__input - The search input element.
 * @part search__form-control - The search form control wrapper.
 * @part menu__base - The menu base.
 * @part spinner__base - The spinner base.
 * @part empty - The empty message.
 */
export declare class ScSelectDropdown {
    /** Element */
    el: HTMLScSelectElement;
    private formController;
    private searchInput;
    private input;
    private inputId;
    private helpId;
    private labelId;
    /** The input's autocomplete attribute. */
    autocomplete: string;
    /** Placeholder for no value */
    placeholder: string;
    /** Placeholder for search */
    searchPlaceholder: string;
    /** The input's value attribute. */
    value: string;
    /** The input's value attribute. */
    choices: Array<ChoiceItem>;
    /** Can we unselect items. */
    unselect: boolean;
    required: boolean;
    loading: boolean;
    /** Is search enabled? */
    search: boolean;
    closeOnSelect: boolean;
    /** The input's name attribute. */
    name: string;
    /** Some help text for the input. */
    help: string;
    /** The input's label. */
    label: string;
    /** The input's size. */
    size: 'small' | 'medium' | 'large';
    position: 'bottom-left' | 'bottom-right' | 'top-left' | 'top-right';
    /** The placement of the dropdown. */
    placement: 'top' | 'top-start' | 'top-end' | 'bottom' | 'bottom-start' | 'bottom-end' | 'right' | 'right-start' | 'right-end' | 'left' | 'left-start' | 'left-end';
    /**
     * This will be true when the control is in an invalid state. Validity is determined by props such as `type`,
     * `required`, `minlength`, `maxlength`, and `pattern` using the browser's constraint validation API.
     */
    invalid: boolean;
    /** Is this open */
    open: boolean;
    disabled: boolean;
    showParentLabel: boolean;
    hoist: boolean;
    squared: boolean;
    squaredBottom: boolean;
    squaredTop: boolean;
    squaredLeft: boolean;
    squaredRight: boolean;
    private hasFocus;
    /** Search term */
    searchTerm: string;
    /** Search term */
    filteredChoices: Array<ChoiceItem>;
    /** Emitted whent the components search query changes */
    scSearch: EventEmitter<string>;
    /** Emitted whent the components search query changes */
    scOpen: EventEmitter<string>;
    /** Emitted whent the components search query changes */
    scClose: EventEmitter<string>;
    /** Emitted when the control loses focus. */
    scBlur: EventEmitter<void>;
    /** Emitted when the control gains focus. */
    scFocus: EventEmitter<void>;
    /** Emitted when the control's value changes. */
    scChange: EventEmitter<ChoiceItem>;
    /** Emitted when the list scrolls to the end. */
    scScrollEnd: EventEmitter<void>;
    /** Trigger focus on show */
    handleShow(): void;
    handleHide(): void;
    handleBlur(): void;
    handleFocus(): void;
    /** Get the display value of the item. */
    displayValue(): string | false;
    isChecked({ value, checked }: {
        value: any;
        checked?: boolean;
    }): boolean;
    /** Sets a custom validation message. If `message` is not empty, the field will be considered invalid. */
    setCustomValidity(message: string): Promise<void>;
    reportValidity(): Promise<boolean>;
    handleQuery(e: any): void;
    handleSelect(choice: any): void;
    handleSearchChange(): void;
    handleValueChange(): void;
    handleOpenChange(): void;
    handleMenuScroll(e: any): void;
    componentWillLoad(): void;
    componentDidLoad(): void;
    getItems(): HTMLScMenuItemElement[];
    handleKeyDown(event: KeyboardEvent): void;
    disconnectedCallback(): void;
    renderIcon(icon: any): any;
    renderItem(choice: ChoiceItem, index: number): any;
    render(): any;
}
