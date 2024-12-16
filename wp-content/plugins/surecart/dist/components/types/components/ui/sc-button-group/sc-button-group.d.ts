export declare class ScButtonGroup {
    el: HTMLScButtonGroupElement;
    label: string;
    separate: boolean;
    findButton(el: HTMLElement): Element;
    handleFocus(event: Event): void;
    handleBlur(event: Event): void;
    handleMouseOver(event: Event): void;
    handleMouseOut(event: Event): void;
    handleSlotChange(): void;
    render(): any;
}
