import { Purchase } from '../../../types';
export declare class ScPurchaseDownloadsList {
    el: HTMLScDownloadsListElement;
    allLink: string;
    heading: string;
    busy: boolean;
    loading: boolean;
    requestNonce: string;
    error: string;
    purchases: Array<Purchase>;
    renderEmpty(): any;
    renderLoading(): any;
    renderList(): any[];
    renderContent(): any;
    render(): any;
}
