export declare const getScriptLoadParams: ({ clientId, reusable, merchantId, currency, merchantInitiated }: {
    clientId: any;
    reusable: any;
    merchantId: any;
    currency?: string;
    merchantInitiated: any;
}) => {
    commit: boolean;
    intent: string;
    vault: boolean;
    currency: string;
    'merchant-id'?: any;
    'client-id': any;
};
