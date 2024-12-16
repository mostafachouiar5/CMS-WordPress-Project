import { ObservableMap } from '@stencil/store';
import { IconLibraryMutator, IconLibraryResolver } from './components/ui/icon/library';
import { StripeElementChangeEvent } from '@stripe/stripe-js';
declare global {
    interface Window {
        grecaptcha: any;
        surecart?: {
            product?: {
                store: ObservableMap<any>;
                state: any;
                update: Function;
            };
        };
        wp: {
            apiFetch: any;
            blocks: any;
            i18n: any;
        };
        dataLayer: any;
        gtag: any;
        fbq: any;
        sc?: {
            store?: {
                product?: any;
                products?: any;
            };
            checkout?: {
                addLineItem: (data: any) => void;
            };
            cart?: {
                toggle: (open: boolean) => void;
            };
        };
        scStore: any;
        registerSureCartIconPath: (path: string) => void;
        registerSureCartIconLibrary: (name: string, options: {
            resolver: IconLibraryResolver;
            mutator?: IconLibraryMutator;
        }) => void;
        scIcons: {
            path: string;
        };
        scData: {
            cdn_root: string;
            root_url: string;
            account_id: string;
            account_slug: string;
            api_url: string;
            home_url: string;
            plugin_url: string;
            page_id: string;
            persist_cart: 'browser' | 'url' | false;
            nonce: string;
            base_url: string;
            nonce_endpoint: string;
            recaptcha_site_key: string;
            theme: string;
            product_data: {
                checkout_link: string;
                mode: 'live' | 'test';
                form: {
                    ID: number;
                };
                product: Product;
            };
            pages: {
                dashboard: string;
                checkout: string;
            };
            currency: string;
            is_claimed: string;
            claim_url: string;
            admin_url: string;
            user_permissions: {
                manage_sc_shop_settings: boolean;
            };
        };
        ceRegisterIconLibrary: any;
        ResizeObserver: any;
    }
}
export type RecursivePartial<T> = {
    [P in keyof T]?: RecursivePartial<T[P]>;
};
interface Model {
    created_at: number;
    updated_at: number;
}
export interface ChoiceItem extends Object {
    value: string;
    label: string;
    description?: string;
    disabled?: boolean;
    checked?: boolean;
    unavailable?: boolean;
    choices?: ChoiceItem[];
    suffix?: string;
    suffixDescription?: string;
    icon?: string;
}
export type ChoiceType = 'all' | 'single' | 'multiple';
export interface Price {
    id: string;
    name: string;
    description?: string;
    amount: number;
    full_amount: number;
    currency: string;
    recurring: boolean;
    recurring_interval?: 'week' | 'month' | 'year' | 'never';
    recurring_interval_count?: number;
    trial_duration_days?: number;
    ad_hoc: boolean;
    ad_hoc_max_amount: number;
    ad_hoc_min_amount: number;
    scratch_amount: number;
    setup_fee_enabled: boolean;
    setup_fee_amount: number;
    setup_fee_name: string;
    setup_fee_trial_enabled: boolean;
    recurring_period_count: number;
    archived: boolean;
    product_id?: string;
    archived_at?: string;
    created_at: number;
    updated_at: number;
    product?: Product | string;
    position: number;
    portal_subscription_update_enabled: boolean;
    metadata: {
        [key: string]: string;
    };
}
export interface VariantOption {
    id: string;
    object: string;
    name: string;
    position: number;
    product: Product | string;
    updated_at: number;
    created_at: number;
    label: string;
    labels: string;
    values: Array<string>;
}
export interface Bump {
    id: string;
    object: 'bump';
    amount_off: number;
    archived: boolean;
    archived_at: number;
    auto_apply: boolean;
    filter_match_type: 'all' | 'any' | 'none';
    filters: any;
    metadata: any;
    name: string;
    percent_off: number;
    price: string | Price;
    priority: 1 | 2 | 3 | 4 | 5;
    created_at: number;
    updated_at: number;
}
export interface UpsellFunnel {
    id: string;
    object: 'upsell_funnel';
    archived: boolean;
    enabled: boolean;
    filter_match_type: 'all' | 'any' | 'none';
    filter_price_ids: string[];
    filter_product_ids: string[];
    metadata: any;
    name: string;
    priority: number;
    upsells: {
        object: 'list';
        pagination: Pagination;
        data: Array<Upsell>;
    };
    archived_at: number;
    discarded_at: number;
    created_at: number;
    updated_at: number;
}
export interface Upsell {
    id: string;
    object: 'upsell';
    amount_off: number;
    metadata: any;
    fee_description: string;
    duplicate_purchase_behavior: 'allow' | 'block' | 'block_within_checkout';
    percent_off: number;
    price: string | Price;
    step: 'initial' | 'accepted' | 'declined';
    upsell_funnel: string | UpsellFunnel;
    permalink: string;
    discarded_at: number;
    created_at: number;
    updated_at: number;
}
export type Prices = {
    [id: string]: Price;
};
export interface Media {
    id: string;
    object: 'media';
    byte_size: number;
    content_type: string;
    extension: string;
    filename: string;
    public_access: boolean;
    release_json: any;
    alt: string;
    title: string;
    url?: string;
    url_expires_at?: number;
    updated_at: number;
    created_at: number;
}
export interface Download {
    id: string;
    object: 'download';
    archived: boolean;
    archived_at?: number;
    media: string | Media;
    name?: string;
    product: string | Product;
    update_at: number;
    created_at: number;
    url?: string;
}
export type FormState = 'idle' | 'loading' | 'draft' | 'updating' | 'finalizing' | 'paying' | 'confirming' | 'confirmed' | 'paid' | 'failure' | 'expired' | 'redirecting';
export type FormStateSetter = 'RESOLVE' | 'REJECT' | 'FINALIZE' | 'PAYING' | 'PAID' | 'EXPIRE' | 'FETCH';
export interface License {
    id: string;
    object: 'license';
    activation_limit: number;
    activation_count: number;
    key: string;
    activations?: {
        object: 'list';
        pagination: Pagination;
        data: Array<Activation>;
    };
    status: 'inactive' | 'active' | 'revoked';
    purchase: string | Purchase;
    created_at: number;
    updated_at: number;
}
export interface CancellationReason {
    id: string;
    object: 'cancellation_reason';
    archived: boolean;
    comment_enabled: false;
    comment_prompt: string | null;
    coupon_enabled: boolean;
    label: string;
    position: number;
    archived_at: number;
    discarded_at: number;
    created_at: number;
    updated_at: number;
}
export interface Period {
    id: string;
    object: 'period';
    ad_hoc_amount?: number;
    checkout: string | Checkout;
    customer_id: string | Customer;
    end_at?: number;
    next_payment_retry_at: number;
    payment_retry_count: number;
    price: string | Price;
    purchase_id: string | Purchase;
    quantity: number;
    renewal: boolean;
    skip_proration: boolean;
    start_at: number;
    status: 'draft';
    subscription: string | Subscription;
    created_at: number;
    updated_at: number;
}
export interface Activation {
    id: string;
    object: 'activation';
    name: string;
    counted: boolean;
    fingerprint: string;
    license: string | License;
    created_at: number;
    updated_at: number;
}
export interface Variant {
    id: string;
    amount: number;
    available_stock: number;
    currency: string;
    current_version: boolean;
    held_stock: number;
    stock: number;
    object: 'variant';
    image?: string | Media;
    image_url?: string;
    option_1?: string | null;
    option_2?: string | null;
    option_3?: string | null;
    position: number;
    product: string | Product;
    sku?: string | null;
    created_at: number;
    updated_at: number;
}
export interface ProductMetrics {
    currency: string;
    max_price_amount: number;
    min_price_amount: number;
    prices_count: number;
}
export interface Product extends Object {
    id: string;
    name: string;
    description: string;
    archived: boolean;
    archived_at: string;
    metadata: any;
    image_url: string;
    recurring: boolean;
    tax_category: string;
    tax_enabled: boolean;
    purchase_limit: number;
    metrics: ProductMetrics;
    line_item_image: ImageAttributes;
    permalink: string;
    weight: number;
    weight_unit: 'kg' | 'lb' | 'g' | 'oz';
    featured_product_media?: string | ProductMedia;
    prices: {
        object: 'list';
        pagination: Pagination;
        data: Array<Price>;
    };
    variants: {
        object: 'list';
        pagination: Pagination;
        data: Array<Variant>;
    };
    variant_options: {
        object: 'list';
        pagination: Pagination;
        data: Array<VariantOption>;
    };
    product_medias: {
        object: 'list';
        pagination: Pagination;
        data: Array<ProductMedia>;
    };
    downloads: {
        object: 'list';
        pagination: Pagination;
        data: Array<Download>;
    };
    product_collections: {
        object: 'list';
        pagination: Pagination;
        data: Array<Collection>;
    };
    stock_enabled: boolean;
    allow_out_of_stock_purchases: boolean;
    stock: number;
    available_stock: number;
    held_stock: number;
    created_at: number;
    updated_at: number;
}
export type Products = {
    [id: string]: Product;
};
export interface Collection extends Object {
    id: string;
    name: string;
    description: string;
    image_url: string;
    created_at: number;
    updated_at: number;
}
export interface Coupon extends Model {
    id: string;
    object: 'coupon';
    amount_off: number;
    valid?: boolean;
    expired: boolean;
    currency: string;
    duration: string;
    duration_in_months: number;
    max_redemptions: number;
    metadata: Object;
    name: string;
    percent_off: number;
    redeem_by: number;
    times_redeemed: number;
}
export interface LineItemData extends Object {
    id?: string;
    price_id?: string;
    variant_id?: string;
    bump?: string;
    quantity: number;
    ad_hoc_amount?: number;
    variant?: string;
}
export type LineItemsData = {
    [id: string]: Array<LineItemData>;
};
export interface ImageAttributes {
    src: string;
    alt?: string;
    class?: string;
    decoding?: string;
    height?: number;
    loading?: string;
    sizes?: string;
    srcset?: string;
    width?: number;
}
export interface LineItem extends Object {
    id?: string;
    ad_hoc_amount?: number;
    name: string;
    object: string;
    quantity: number;
    checkout: string | Checkout;
    bump: string | Bump;
    image: ImageAttributes;
    fees?: {
        object: 'list';
        pagination: Pagination;
        data: Array<Fee>;
    };
    bump_amount: number;
    discount_amount: number;
    subtotal_amount: number;
    total_amount: number;
    trial_amount: number;
    tax_amount: number;
    fees_amount: number;
    scratch_amount: number;
    trial: boolean;
    total_savings_amount: number;
    created_at: number;
    updated_at: number;
    price?: Price;
    price_id: string;
    purchasable_status: 'price_gone' | 'price_old_version' | 'variant_mising' | 'variant_gone' | 'variant_old_version' | 'out_of_stock' | 'exceeds_purchase_limit' | 'purchasable';
    purchasable_status_display: string;
    variant_options: Array<string>;
    variant?: Variant;
    locked: boolean;
}
export interface DeletedItem {
    cache_status: string;
    deleted: boolean;
    id: string;
    object: string;
}
export interface Fee {
    id: string;
    object: 'fee';
    amount: number;
    description: string;
    fee_type: 'manual' | 'bump' | 'setup' | 'upsell';
    line_item: string | LineItem;
    created_at: number;
    updated_at: number;
}
export interface InvoiceItem extends LineItem {
}
export interface PriceChoice {
    id: string;
    product_id: string;
    quantity: number;
    enabled: boolean;
    selected?: boolean;
    variant?: string | null;
}
export type CheckoutState = 'idle' | 'loading' | 'draft' | 'updating' | 'finalized' | 'paid' | 'failure';
export type TaxStatus = 'disabled' | 'address_invalid' | 'reverse_charged' | 'tax_registration_not_found' | 'tax_zone_not_found' | 'estimated' | 'calculated';
export interface Invoice extends Object {
    id: string;
    object: 'invoice';
    automatic_collection: boolean;
    due_date?: number;
    issue_date?: number;
    footer?: string;
    memo?: string;
    live_mode: boolean;
    status: InvoiceStatus;
    checkout: Checkout | string;
    metadata: object;
    order_number: string;
    created_at: number;
    updated_at: number;
}
export interface BillingAddress extends Address {
}
export interface ShippingAddress extends Address {
}
export interface ProductGroup {
    id: string;
    object: 'product_group';
    archived: boolean;
    archived_at: number;
    metadata: object;
    name: string;
    created_at: number;
    updated_at: number;
}
export interface ProductMedia {
    id: string;
    object: 'product_media';
    position: number;
    url: null;
    media: string | Media;
    product: string | Product;
    created_at: number;
    updated_at: number;
}
export interface Charge extends Object {
    amount: number;
    created_at: number;
    currency: string;
    customer: string | Customer;
    external_charge_id: string;
    fully_refunded: boolean;
    id: string;
    invoice: string | Invoice;
    live_mode: boolean;
    object: 'charge';
    checkout: string | Checkout;
    payment_method: string | PaymentMethod;
    refunded_amount: number;
    status: 'pending' | 'succeeded' | 'failed';
    updated_at: number;
}
export interface TaxIdentifier {
    id: string;
    number: string;
    number_type: string;
    object: 'tax_identifier';
    eu_vat_verified: boolean;
    created_at: number;
    updated_at: number;
}
export interface TaxProtocol {
    id: string;
    object: 'tax_protocol';
    ca_tax_enabled: boolean;
    eu_micro_exemption_enabled: boolean;
    eu_tax_enabled: boolean;
    eu_vat_required: boolean;
    eu_vat_unverified_behavior: 'error' | 'apply_reverse_charge' | 'skip_reverse_charge';
    eu_vat_local_reverse_charge: boolean;
    tax_enabled: boolean;
    address: string | Address;
    ca_tax_identifier: string | TaxIdentifier;
    eu_tax_identifier: string | TaxIdentifier;
    created_at: number;
    updated_at: number;
}
export interface Order extends Object {
    id?: string;
    object: 'order';
    number?: string;
    order_type?: 'checkout' | 'subscription';
    statement_url?: string;
    status?: OrderStatus;
    shipment_status?: OrderShipmentStatus;
    checkout?: Checkout | string;
    invoice?: Invoice | string;
    created_at: number;
    updated_at: number;
}
export interface ShippingChoice {
    amount: number;
    checkout: string | Checkout;
    currency: string;
    id: string;
    object: 'shipping_choice';
    shipping_method: string | ShippingMethod;
    created_at: number;
    updated_at: number;
}
export interface ShippingMethod {
    name: string;
    description: string;
    id: string;
    object: 'shipping_method';
    position: number;
    created_at: number;
    updated_at: number;
}
export interface Checkout extends Object {
    id?: string;
    status?: 'canceled' | 'draft' | 'finalized' | 'paid' | 'payment_intent_canceled' | 'payment_failed' | 'processing';
    staged_payment_intents: {
        object: 'list';
        pagination: Pagination;
        data: Array<PaymentIntent>;
    };
    abandoned_checkout_enabled: boolean;
    billing_matches_shipping: boolean;
    bump_amount: number;
    payment_method_required?: boolean;
    manual_payment: boolean;
    manual_payment_method?: string | ManualPaymentMethod;
    reusable_payment_method_required?: boolean;
    number?: string;
    amount_due?: number;
    remaining_amount_due?: number;
    trial_amount?: number;
    charge?: string | Charge;
    name?: string;
    first_name?: string;
    last_name?: string;
    email?: string;
    phone?: string;
    live_mode?: boolean;
    currency?: string;
    total_amount?: number;
    subtotal_amount?: number;
    full_amount?: number;
    paid_amount?: number;
    proration_amount?: number;
    total_savings_amount?: number;
    applied_balance_amount?: number;
    discounts?: number;
    shipping_address_required?: boolean;
    tax_enabled: boolean;
    tax_amount: number;
    email_exists: boolean;
    tax_inclusive_amount: number;
    tax_exclusive_amount: number;
    tax_status: 'disabled' | 'address_invalid' | 'estimated' | 'calculated';
    tax_label: string;
    tax_percent: number;
    line_items: lineItems;
    recommended_bumps?: {
        object: 'list';
        pagination: Pagination;
        data: Array<Bump>;
    };
    current_upsell: Upsell;
    recommended_upsells?: {
        object: 'list';
        pagination: Pagination;
        data: Array<Upsell>;
    };
    metadata?: any;
    payment_intent?: PaymentIntent;
    payment_method?: PaymentMethod;
    order?: string | Order;
    customer: string | Customer;
    subscriptions: {
        object: 'list';
        pagination: Pagination;
        data: Array<Subscription>;
    };
    purchases: {
        object: 'list';
        pagination: Pagination;
        data: Array<Purchase>;
    };
    discount_amount?: number;
    discount?: DiscountResponse;
    billing_address?: string | Address;
    shipping_amount?: number;
    shipping_address?: string | Address;
    shipping_enabled?: boolean;
    shipping_choices?: {
        object: 'list';
        pagination: Pagination;
        data: Array<ShippingChoice>;
    };
    selected_shipping_choice?: string | ShippingChoice;
    selected_shipping_choice_required: boolean;
    processor_data?: ProcessorData;
    tax_identifier?: {
        number: string;
        number_type: string;
    };
    url: string;
    created_at?: number;
    updated_at: number;
    variant: string;
    upsells_expire_at?: number;
    invoice?: string | Invoice;
    pdf_url?: string;
}
export interface ShippingMethod {
    id: string;
    object: 'shipping_method';
    description: string | null;
    name: string;
    position: number;
    created_at: number;
    updated_at: number;
}
export interface ShippingChoice {
    id: string;
    object: 'shipping_choice';
    amount: number;
    currency: string;
    checkout: string | Checkout;
    shipping_method: string | ShippingMethod;
    created_at: number;
    updated_at: number;
}
export interface ProcessorData {
    stripe: {
        account_id: string;
        publishable_key: string;
        client_secret?: string;
        type: 'payment' | 'setup';
    };
    paypal: {
        account_id: string;
        client_id: string;
        merchant_initiated: boolean;
    };
    mollie?: {
        account_id: 'string';
        checkout_url: 'string';
    };
    paystack: {
        account_id: string;
        public_key: string;
        access_code: string;
    };
}
export interface ManualPaymentMethod {
    id: string;
    object: 'manual_payment_method';
    archived: boolean;
    archived_at: number;
    description: string;
    instructions: string;
    name: string;
    created_at: number;
    updated_at: number;
}
export interface PaymentMethodType {
    id: string;
    description: string;
    image: string;
}
export interface Processor {
    id: string;
    live_mode: boolean;
    processor_data: {
        account_id: string;
        recurring_enabled: boolean;
        client_id: string;
        merchant_initiated?: boolean;
    };
    recurring_enabled: boolean;
    supported_currencies: Array<string>;
    processor_type: 'paypal' | 'stripe' | 'mollie' | 'mock';
}
export interface Purchase {
    id: string;
    object: 'purchase';
    live_mode: boolean;
    quantity: number;
    revoked: boolean;
    revoked_at: number;
    customer: string | Customer;
    invoice_item: string | InvoiceItem;
    invoice: string | Invoice;
    line_item: string | LineItem;
    order: string | Order;
    product: string | Product;
    refund: string | Refund;
    subscription: string | Subscription;
    license: string | License;
    created_at: number;
    updated_at: number;
}
export interface Refund {
    id: string;
    object: 'refund';
    amount: number;
    currency: string;
    external_refund_id: string;
    live_mode: boolean;
    metadata: object;
    reason: 'duplicate' | 'fraudulent' | 'requested_by_customer' | 'expired_uncaptured_charge';
    status: 'pending' | 'succeeded' | 'failed' | 'canceled';
    charge: string | Charge;
    customer: string | Customer;
    revoked_purchases: null | Array<Purchase>;
    created_at: number;
    updated_at: number;
}
export interface Subscription extends Object {
    id: string;
    object: 'subscription';
    currency?: string;
    status: SubscriptionStatus;
    live_mode: boolean;
    external_subscription_id: string;
    current_cancellation_act: string | CancellationAct;
    trial_end_at: number;
    processor_type: 'stripe' | 'paypal';
    order: Order;
    customer: Customer;
    discount: DiscountResponse;
    finite: boolean;
    pending_update: {
        ad_hoc_amount?: number;
        price?: string;
        quantity?: number;
        variant?: string;
    };
    purchase: Purchase | string;
    cancel_at_period_end: number | false;
    current_period: string | Period;
    current_period_end_at: number | false;
    current_period_start_at: number | false;
    remaining_period_count: number | null;
    ended_at: number;
    end_behavior: 'cancel' | 'complete';
    payment_method: PaymentMethod | string;
    manual_payment_method: ManualPaymentMethod | string;
    manual_payment: boolean;
    price: Price;
    ad_hoc_amount: number;
    variant?: Variant | string;
    variant_options?: Array<string>;
    created_at: number;
    updated_at: number;
    restore_at?: number;
}
export interface CancellationAct {
    id: string;
    object: 'cancellation_act';
    cancellation_reason: string | CancellationReason;
    comment: string;
    coupon_applied: boolean;
    preserved: boolean;
    subscription: string | Subscription;
    performed_at: number;
    created_at: number;
    updated_at: number;
}
export interface SubscriptionProtocol {
    id: string;
    object: 'subscription_protocol';
    cancel_behavior: 'pending' | 'immediate';
    downgrade_behavior: 'pending' | 'immediate';
    payment_retry_window_weeks: number;
    upgrade_behavior: 'pending' | 'immediate';
    preservation_enabled: boolean;
    preservation_locales: {
        reasons_title: string;
        reasons_description: string;
        skip_link: string;
        preserve_title: string;
        preserve_description: string;
        preserve_button: string;
        cancel_link: string;
    };
    preservation_coupon: Coupon | string;
    created_at: number;
    updated_at: number;
}
export type SubscriptionStatus = 'incomplete' | 'trialing' | 'active' | 'past_due' | 'canceled' | 'unpaid' | 'completed';
export type CheckoutStatus = 'draft' | 'finalized' | 'paid' | 'payment_intent_canceled' | 'payment_failed' | 'requires_approval';
export type OrderStatus = 'paid' | 'payment_failed' | 'processing' | 'void' | 'canceled' | 'draft';
export type InvoiceStatus = 'paid' | 'open' | 'draft';
export type OrderFulFillmentStatus = 'fulfilled' | 'unfulfilled' | 'partially_fulfilled' | 'scheduled' | 'on_hold';
export type OrderShipmentStatus = 'unshipped' | 'shipped' | 'partially_shipped' | 'delivered' | 'unshippable';
export type FulfillmentStatus = 'unshipped' | 'shipped' | 'delivered' | 'unshippable';
export type ReturnRequestStatus = 'open' | 'completed';
export interface PaymentMethod extends Object {
    id: string;
    object: 'payment_method';
    live_mode: boolean;
    external_payment_method_id: string;
    processor_type: 'stripe' | 'paypal';
    paypal_account: any;
    type: string;
    bank_account: BankAccount | string;
    payment_instrument: PaymentInstrument | string;
    payment_method_name: string;
    payment_intent: PaymentIntent | string;
    billing_agreement?: BillingAgreement | string;
    card: any;
    customer: Customer | string;
    created_at: number;
    updated_at: number;
}
export interface BankAccount {
    id: string;
    account_type: 'checking' | 'savings';
    account_holder_type: 'individual' | 'company';
    bank_name: string;
    last4: string;
    created_at: number;
    updated_at: number;
}
export interface PaymentInstrument {
    id: string;
    instrument_type: string;
    metadata: any;
    object: 'payment_instrument';
    created_at: number;
    updated_at: number;
}
export interface BillingAgreement {
    email: string;
    external_customer_id: string;
    first_name: string;
    id: string;
    last_name: string;
    phone: string;
    object: 'billing_agreement';
    created_at: number;
    updated_at: number;
}
export interface Pagination {
    count: number;
    limit: number;
    page: number;
    url: string;
}
export interface lineItems extends Object {
    object: 'list';
    pagination: Pagination;
    data: Array<LineItem>;
}
export interface Promotion extends Object {
    code: string;
    created_at: number;
    expired: boolean;
    id: string;
    max_redemptions: number;
    metadata: Object;
    object: 'promotion';
    redeem_by: string;
    times_redeemed: number;
}
export interface DiscountResponse {
    coupon?: Coupon;
    id: string;
    object: 'discount';
    promotion: Promotion;
    redeemable_status: string;
}
export interface ResponseError {
    code?: string;
    message: string;
    data?: {
        http_status: string;
        status?: number;
        type: string;
    };
    additional_errors?: Array<{
        code: string;
        message: string;
        data: {
            attribute: string;
            options: Array<string>;
            type: string;
        };
    }>;
}
export type ProcessorName = 'stripe' | 'paypal' | 'paypal-card';
export interface VerificationCode {
    id: string;
    object: 'verification_code';
    code: number;
    verified: boolean;
    verified_at: number | null;
    created_at: number;
    updated_at: number;
}
export interface PaymentIntent extends Object {
    id: string;
    object: 'payment_intent';
    amount: number;
    currency: string;
    processor_type: 'stripe' | 'paypal';
    status: 'pending' | 'succeeded' | 'canceled';
    external_intent_id: string;
    live_mode: boolean;
    processor_data: ProcessorData;
    customer: Customer | string;
    created_at: number;
    updated_at: number;
    payment_method: PaymentMethod | string;
}
export interface PaymentIntents {
    stripe?: PaymentIntent;
    paypal?: PaymentIntent;
}
export interface SetupIntent extends Object {
    id: string;
    object: 'setup_intent';
    processor_type: 'stripe' | 'paypal';
    status: 'pending' | 'succeeded' | 'canceled';
    external_intent_id: string;
    live_mode: boolean;
    processor_data: ProcessorData;
    customer: Customer | string;
    created_at: number;
    updated_at: number;
}
export interface WordPressUser {
    id: number;
    display_name: string;
    first_name: string;
    last_name: string;
    email: string;
}
export interface Customer extends Object {
    id: string;
    email: string;
    name?: string;
    first_name?: string;
    last_name?: string;
    phone?: string;
    billing_address?: string | Address;
    billing_address_display?: string | Address;
    shipping_address?: string | Address;
    billing_matches_shipping: boolean;
    live_mode: boolean;
    unsubscribed: boolean;
    default_payment_method: string | PaymentMethod;
    tax_identifier: {
        number: string;
        number_type: string;
    };
    created_at: number;
    updated_at: number;
}
export interface Address extends Object {
    name?: string;
    line_1?: string;
    line_2?: string;
    city?: string;
    state?: string;
    postal_code?: string;
    country?: string;
}
export interface Fulfillment {
    id: string;
    object: 'fulfillment';
    number: string;
    shipment_status: FulfillmentStatus;
    trackings: {
        object: 'list';
        pagination: Pagination;
        data: Array<Tracking>;
    };
    fulfillment_items: {
        object: 'list';
        pagination: Pagination;
        data: Array<FulfillmentItem>;
    };
}
export interface FulfillmentItem {
    id: string;
    line_item: LineItem;
    quantity: number;
    fulfillment: string | Fulfillment;
}
export interface Tracking {
    courier_name?: string;
    number: string;
    url: string;
}
export interface PriceData extends Object {
    price_id: string;
    quantity: number;
    removeable: boolean;
}
export type TaxZone = {
    label: string;
    label_small: string;
};
export type TaxZones = {
    [key in 'ca_gst' | 'au_abn' | 'gb_vat' | 'eu_vat' | 'other']: TaxZone;
};
export type RuleName = 'total' | 'coupons' | 'products' | 'shipping_country' | 'billing_country' | 'processors';
export type ArrayOperators = 'all' | 'any' | 'none' | 'exist' | 'not_exist';
export type NumberOperators = '==' | '!=' | '<' | '>' | '<=' | '>=';
export interface RuleGroup {
    group_id: string;
    rules: Rule[];
}
export interface Rule {
    condition: RuleName;
    operator: NumberOperators | ArrayOperators;
    value: string | string[] | {
        value: string;
    }[];
}
export interface ProductCollection {
    id: string;
    object: string;
    name: string;
    description?: string;
    position?: number;
    slug: string;
    image?: string;
    products_count: number;
    products?: Product[];
}
export interface GoogleAnalyticsItem {
    item_id: string;
    item_name: string;
    item_variant?: string;
    item_category?: string;
    item_category2?: string;
    item_category3?: string;
    item_category4?: string;
    item_category5?: string;
    price: number;
    quantity: number;
    coupon?: string;
    currency: string;
    discount?: number;
}
export interface ProductState {
    formId: number;
    mode: 'live' | 'test';
    product: Product;
    prices: Price[];
    variants: Variant[];
    variant_options: VariantOption[];
    quantity: number;
    selectedPrice: Price;
    total: number;
    busy: boolean;
    disabled: boolean;
    checkoutUrl: string;
    adHocAmount: number;
    dialog: string;
    line_item: LineItemData;
    error: string;
    selectedVariant?: Variant;
    variantValues: {
        option_1?: string;
        option_2?: string;
        option_3?: string;
    };
    isProductPage?: boolean;
}
export interface FeaturedProductMediaAttributes {
    alt: string;
    url: string;
    title: string;
}
export interface PaymentInfoAddedParams {
    checkout_id: string;
    processor_type: 'paypal' | 'stripe' | 'mollie' | 'paystack';
    currency: string;
    total_amount: number;
    line_items?: lineItems;
    payment_method: {
        billing_details: {
            name: string;
            email: string;
        };
    };
}
export interface CheckoutInitiatedParams {
    transaction_id: string;
    value: number;
    currency: string;
    coupon?: string;
    tax?: number;
    items: Array<{
        item_name: string;
        discount: number;
        price: number;
        quantity: number;
    }>;
}
export interface ProductsSearchedParams {
    searchString: string;
    searchCollections?: string[];
    searchResultCount: number;
    searchResultIds: string[];
}
export interface ProductsViewedParams {
    products: Product[];
    pageTitle: string;
    collectionId?: string;
}
export type NoticeType = 'default' | 'info' | 'success' | 'warning' | 'error';
interface AdditionalError {
    code: string;
    message: string;
    data: {
        attribute: string;
        type: string;
        options: {
            if: string[];
            value: string;
        };
    };
}
export interface ScNoticeStore {
    type: NoticeType | 'default';
    code: string;
    message: string;
    data?: {
        status: number;
        type: string;
        http_status: string;
    };
    additional_errors?: AdditionalError[] | null;
    dismissible?: boolean;
}
export interface CustomStripeElementChangeEvent extends StripeElementChangeEvent {
    value?: {
        type: string;
    };
}
export {};
