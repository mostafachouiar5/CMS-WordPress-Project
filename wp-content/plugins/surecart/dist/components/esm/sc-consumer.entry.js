import { r as registerInstance, c as createEvent } from './index-745b6bec.js';

const ScConsumer = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.mountEmitter = createEvent(this, "mountConsumer", 7);
        this.setContext = async (context) => {
            this.context = context;
            return this.promise;
        };
        this.renderer = undefined;
        this.context = undefined;
        this.promise = undefined;
        this.resolvePromise = undefined;
        this.promise = new Promise(resolve => {
            this.resolvePromise = resolve;
        });
    }
    componentWillLoad() {
        this.mountEmitter.emit(this.setContext);
    }
    disconnectedCallback() {
        this.resolvePromise();
    }
    render() {
        if (!this.context) {
            return null;
        }
        return this.renderer(this.context);
    }
};

export { ScConsumer as sc_consumer };

//# sourceMappingURL=sc-consumer.entry.js.map