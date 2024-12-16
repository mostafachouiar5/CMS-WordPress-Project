import { License } from '../../../../types';
export declare class ScLicensesList {
    el: HTMLScLicensesListElement;
    /** Query to fetch licenses */
    query: {
        page: number;
        per_page: number;
    };
    /**The heading of the licenses */
    heading: string;
    /**Whether the current user is customer */
    isCustomer: boolean;
    /**View all link */
    allLink: string;
    licenses: License[];
    copied: boolean;
    loading: boolean;
    error: string;
    pagination: {
        total: number;
        total_pages: number;
    };
    /** Only fetch if visible */
    componentWillLoad(): void;
    initialFetch(): Promise<void>;
    getLicenses(): Promise<License[]>;
    renderStatus(status: string): any;
    copyKey(key: string): Promise<void>;
    renderLoading(): any;
    renderEmpty(): any;
    renderContent(): any;
    render(): any;
}
