import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScTabGroup {
    el: HTMLScTabGroupElement;
    activeTab: HTMLScTabElement;
    private tabs;
    private panels;
    scTabHide: EventEmitter<string>;
    scTabShow: EventEmitter<string>;
    private mutationObserver;
    componentDidLoad(): void;
    disconnectedCallback(): void;
    syncTabsAndPanels(): void;
    setAriaLabels(): void;
    handleClick(event: MouseEvent): void;
    handleKeyDown(event: KeyboardEvent): boolean;
    /** Handle the active tabl selection */
    setActiveTab(tab: HTMLScTabElement, options?: {
        emitEvents?: boolean;
        scrollBehavior?: 'auto' | 'smooth';
    }): void;
    getActiveTab(): HTMLScTabElement;
    getAllChildren(): HTMLElement[];
    /** Get all child tabs */
    getAllTabs(includeDisabled?: boolean): HTMLScTabElement[];
    /** Get all child panels */
    getAllPanels(): [HTMLScTabPanelElement];
    render(): any;
}
