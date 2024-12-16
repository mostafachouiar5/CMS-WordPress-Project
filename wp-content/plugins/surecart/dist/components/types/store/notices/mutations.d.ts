import { NoticeType, ScNoticeStore } from '../../types';
/**
 * Create a notice.
 *
 * @param {NoticeType} status
 * @param {ScNoticeStore} notice
 */
export declare const createNotice: (status: NoticeType, notice: ScNoticeStore, options?: {
    dismissible: boolean;
}) => void;
/**
 * Create an error notice.
 *
 * @param {ScNoticeStore} notice
 * @param {object} options
 */
export declare const createErrorNotice: (notice: any, options?: {
    dismissible: boolean;
}) => void;
/**
 * Create a success notice.
 *
 * @param {ScNoticeStore} notice
 * @param {object} options
 */
export declare const createSuccessNotice: (notice: any, options?: {
    dismissible: boolean;
}) => void;
/**
 * Create an info notice.
 *
 * @param {ScNoticeStore} notice
 * @param {object} options
 */
export declare const createInfoNotice: (notice: any, options?: {
    dismissible: boolean;
}) => void;
/**
 * Create a warning notice.
 *
 * @param {ScNoticeStore} notice
 * @param {object} options
 */
export declare const createWarningNotice: (notice: any, options?: {
    dismissible: boolean;
}) => void;
/**
 * Remove the notice.
 */
export declare const removeNotice: () => void;
