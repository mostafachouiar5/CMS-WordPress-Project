'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const ScConsumer = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.mountEmitter = index.createEvent(this, "mountConsumer", 7);
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

exports.sc_consumer = ScConsumer;

//# sourceMappingURL=sc-consumer.cjs.entry.js.map