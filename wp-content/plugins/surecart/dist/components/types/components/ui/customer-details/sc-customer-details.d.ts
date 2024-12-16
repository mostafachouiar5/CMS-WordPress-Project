import { Address, Customer } from '../../../types';
/**
 * @part base - The elements base wrapper.
 * @part heading - The heading.
 * @part heading-text - The heading text wrapper.
 * @part heading-title - The heading title.
 * @part heading-description - The heading description.
 * @part error__base - The elements base wrapper.
 * @part error__icon - The alert icon.
 * @part error__text - The alert text.
 * @part error__title - The alert title.
 * @part error__ message - The alert message.
 * @part test-tag__base - The base test tag.
 * @part text-tag__content - The base test tag content.
 * @part button__base - The button base.
 * @part button__label - The button label.
 * @part button__prefix - The button prefix.
 */
export declare class ScCustomerDetails {
    el: HTMLScCustomerDetailsElement;
    heading: string;
    editLink: string;
    customer: Customer;
    loading: boolean;
    error: string;
    renderContent(): any;
    renderAddress(label: string, address: Address): any;
    renderEmpty(): any;
    renderLoading(): any;
    render(): any;
}
