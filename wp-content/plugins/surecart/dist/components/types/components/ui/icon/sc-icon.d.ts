import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScIcon {
    private svg;
    /** The name of the icon to draw. */
    name: string;
    /** An external URL of an SVG file. */
    src: string;
    /** An alternative description to use for accessibility. If omitted, the name or src will be used to generate it. */
    label: string;
    /** The name of a registered custom icon library. */
    library: string;
    /** Emitted when the icon has loaded. */
    scLoad: EventEmitter<void>;
    /** @internal Fetches the icon and redraws it. Used to handle library registrations. */
    redraw(): void;
    componentWillLoad(): void;
    getLabel(): string;
    setIcon(): Promise<void>;
    private getUrl;
    render(): any;
}
