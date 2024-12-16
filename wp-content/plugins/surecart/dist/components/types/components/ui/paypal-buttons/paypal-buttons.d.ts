import { EventEmitter } from '../../../stencil-public-runtime';
import { Checkout } from '../../../types';
export declare class ScPaypalButtons {
    /** This element. */
    el: HTMLScPaypalButtonsElement;
    /** Holds the card button */
    private cardContainer;
    /** Holds the paypal buttons */
    private paypalContainer;
    /** Client id for the script. */
    clientId: string;
    /** Is this busy? */
    busy: boolean;
    /** The merchant id for paypal. */
    merchantId: string;
    /** Merchant initiated billing enabled. */
    merchantInitiated: boolean;
    /** Test or live mode. */
    mode: 'test' | 'live';
    /** The order. */
    order: Checkout;
    /** Buttons to render */
    buttons: string[];
    /** Label for the button. */
    label: 'paypal' | 'checkout' | 'buynow' | 'pay' | 'installment';
    /** Button color. */
    color: 'gold' | 'blue' | 'silver' | 'black' | 'white';
    /** Has this loaded? */
    loaded: boolean;
    /** Set the state machine */
    scSetState: EventEmitter<string>;
    scPaid: EventEmitter<void>;
    handleOrderChange(val: any, prev: any): void;
    /** Load the script */
    loadScript(): Promise<void>;
    /** Load the script on component load. */
    componentDidLoad(): void;
    /** Render the buttons. */
    renderButtons(paypal: any): void;
    render(): any;
}
