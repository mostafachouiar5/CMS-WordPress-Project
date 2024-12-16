import { License } from "../../../../types";
export declare class ScLicense {
    el: HTMLScLicenseElement;
    /**The license id */
    licenseId: string;
    loading: boolean;
    error: string;
    license: License;
    copied: boolean;
    showConfirmDelete: boolean;
    selectedActivationId: string;
    deleteActivationError: string;
    busy: boolean;
    /** Only fetch if visible */
    componentWillLoad(): void;
    initialFetch(): Promise<void>;
    getLicense(): Promise<void>;
    deleteActivation: () => Promise<void>;
    copyKey(key: string): Promise<void>;
    renderStatus(): any;
    renderLoading(): any;
    renderEmpty(): any;
    renderLicenseHeader(): any;
    renderContent(): any;
    onCloseDeleteModal: () => void;
    renderConfirmDelete(): any;
    render(): any;
}
