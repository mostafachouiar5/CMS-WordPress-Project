import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScOrderSummary {
    private body;
    el: HTMLScOrderSummaryElement;
    loading: boolean;
    busy: boolean;
    closedText: string;
    openText: string;
    collapsible: boolean;
    collapsedOnMobile: boolean;
    collapsedOnDesktop: boolean;
    collapsed: boolean;
    /** Show the toggle */
    scShow: EventEmitter<void>;
    /** Show the toggle */
    scHide: EventEmitter<void>;
    isMobileScreen(): boolean;
    componentWillLoad(): void;
    handleClick(e: any): void;
    renderHeader(): any;
    handleOpenChange(): Promise<void>;
    render(): any;
}
