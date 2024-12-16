import { Bump } from '../../../../types';
export declare class ScOrderBump {
    /** The bump */
    bump: Bump;
    /** Should we show the controls */
    showControl: boolean;
    /** The bump line item */
    lineItem(): import("../../../../types").LineItem;
    /** Update the line item. */
    updateLineItem(): void;
    componentDidLoad(): void;
    newPrice(): any;
    renderInterval(): any;
    renderPrice(): any;
    renderDiscount(): any;
    render(): any;
}
