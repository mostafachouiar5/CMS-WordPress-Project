import { FunctionalComponent } from '../../../stencil-public-runtime';
export declare const createContext: <T extends {
    [key: string]: any;
}>(defaultValue: T) => {
    Provider: FunctionalComponent<{
        value?: T;
    }>;
    Consumer: FunctionalComponent<{}>;
};
