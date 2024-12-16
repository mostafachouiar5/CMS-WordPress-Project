import { MinimumStorage } from './types';
export declare const createStorageStore: <T extends object>(storage: MinimumStorage, key: string, defaultValues: T, syncAcrossTabs?: boolean) => import("@stencil/store").ObservableMap<T>;
export declare const createLocalStore: <T extends object>(key: string, defaultValues: T, syncAcrossTabs?: boolean) => import("@stencil/store").ObservableMap<T>;
export declare const createSessionStore: <T extends object>(key: string, defaultValues: T) => import("@stencil/store").ObservableMap<T>;
