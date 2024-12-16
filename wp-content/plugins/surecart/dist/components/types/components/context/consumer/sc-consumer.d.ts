import { EventEmitter } from '../../../stencil-public-runtime';
export declare class ScConsumer {
    renderer: any;
    context: any;
    mountEmitter: EventEmitter;
    promise: Promise<any>;
    resolvePromise: any;
    constructor();
    setContext: (context: any) => Promise<any>;
    componentWillLoad(): void;
    disconnectedCallback(): void;
    render(): any;
}
