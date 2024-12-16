import { Download } from '../../../../types';
export declare class ScDownloadsList {
    downloads: Download[];
    customerId: string;
    heading: string;
    busy: string;
    error: string;
    downloadItem(download: any): Promise<void>;
    downloadFile(path: any, filename: any): void;
    renderFileExt: (download: any) => any;
    render(): any;
}
