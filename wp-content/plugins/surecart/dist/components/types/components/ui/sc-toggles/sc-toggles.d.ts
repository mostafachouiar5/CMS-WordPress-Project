export declare class ScToggles {
    /** The element */
    el: HTMLScTogglesElement;
    /** Should this function as an accordion? */
    accordion: boolean;
    /** Are these collapsible? */
    collapsible: boolean;
    /** Theme for the toggles */
    theme: 'default' | 'container';
    getToggles(): HTMLScToggleElement[];
    handleShowChange(e: any): void;
    handleCollapibleChange(): void;
    componentDidLoad(): void;
    render(): any;
}
