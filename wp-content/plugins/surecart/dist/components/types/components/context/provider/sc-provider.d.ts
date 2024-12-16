import { EventEmitter } from '../../../stencil-public-runtime';
interface ConsumerEvent extends Event {
    detail: Function;
}
export declare class ScProvider {
    STENCIL_CONTEXT: {
        [key: string]: any;
    };
    consumers: Function[];
    watchContext(newContext: any): void;
    mountEmitter: EventEmitter;
    mountConsumer(event: ConsumerEvent): Promise<void>;
    disconnectedCallback(): void;
    render(): any;
}
export {};
