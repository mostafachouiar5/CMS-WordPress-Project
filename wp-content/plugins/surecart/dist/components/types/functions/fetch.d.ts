import apiFetch from '@wordpress/api-fetch';
export default apiFetch;
/**
 * Calls the `json` function on the Response, throwing an error if the response
 * doesn't have a json function or if parsing the json itself fails.
 *
 * @param {Response} response
 * @return {Promise<any>} Parsed response.
 */
export declare const parseJsonAndNormalizeError: (response: any) => any;
export declare const handleNonceError: (response: any) => Promise<void>;
