import { Checkout } from '../../../../types';
export declare class ScSessionDetail {
    order: Checkout;
    value: string;
    fallback: string;
    metaKey: string;
    loading: boolean;
    label: string;
    getPropByPath(object: any, path: any, defaultValue: any): any;
    getValue(): any;
    render(): any;
}
