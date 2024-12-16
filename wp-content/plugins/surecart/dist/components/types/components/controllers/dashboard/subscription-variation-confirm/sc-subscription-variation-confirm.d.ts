import { Product, Subscription, Price } from '../../../../types';
export declare class ScSubscriptionVariationConfirm {
    heading: string;
    product: Product;
    price: Price;
    subscription: Subscription;
    busy: boolean;
    variantValues: Array<string>;
    constructor();
    componentWillLoad(): void;
    handleSubmit(): Promise<void>;
    buttonText(): string;
    render(): any;
}
