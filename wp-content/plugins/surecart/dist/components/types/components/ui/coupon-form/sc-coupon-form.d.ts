import { EventEmitter } from '../../../stencil-public-runtime';
import { DiscountResponse } from '../../../types';
/**
 * @part base - The elements base wrapper.
 * @part form - The form.
 * @part input__base - The input base.
 * @part input - The input.
 * @part input__form-control - The input form control.
 * @part button__base - The button base element.
 * @part button__label - The button label.
 * @part info - The discount info.
 * @part discount - The discount displayed (% off)
 * @part amount - The discount amount.
 * @part discount-label - The discount label.
 * @part coupon-tag - The coupon tag.
 * @part error__base - The error base.
 * @part error__icon - The error icon
 * @part error__text - The error text.
 * @part error_title - The error title.
 * @part error__message - The error message.
 * @part block-ui - The block ui base component.
 * @part block-ui__content - The block ui content (spinner).
 */
export declare class ScCouponForm {
    el: HTMLScCouponFormElement;
    private input;
    private couponTag;
    private addCouponTrigger;
    /** The label for the coupon form */
    label: string;
    /** Is the form loading */
    loading: boolean;
    /** Is the form calculating */
    busy: boolean;
    /** The placeholder for the input */
    placeholder: string;
    /** The error message */
    error: string;
    /** Force the form to show */
    forceOpen: boolean;
    /** The discount */
    discount: DiscountResponse;
    /** Currency */
    currency: string;
    /** The discount amount */
    discountAmount: number;
    /** Has recurring */
    showInterval: boolean;
    /** Is it open */
    open: boolean;
    collapsed: boolean;
    /** The value of the input */
    value: string;
    /** When the coupon is applied */
    scApplyCoupon: EventEmitter<string>;
    /** The text for apply button */
    buttonText: string;
    /** Is the form editable */
    editable: boolean;
    /** Auto focus the input when opened. */
    handleOpenChange(val: any): void;
    /** Close it when blurred and no value. */
    handleBlur(): void;
    getHumanReadableDiscount(): string;
    /** Apply the coupon. */
    applyCoupon(): void;
    handleKeyDown(e: any): void;
    translateHumanDiscountWithDuration(humanDiscount: any): any;
    /** Focus the input. */
    triggerFocus(): Promise<void>;
    renderTrialText(): string;
    render(): any;
}
