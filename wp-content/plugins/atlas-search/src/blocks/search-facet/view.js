/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */
import { store } from '@wordpress/interactivity';
import '../stores/facets.store';
import { config } from '../config';
import { getFiltersFromURL } from '../utils/getFiltersFromURL';

const { actions, state } = store(config.facetsStoreName, {
  state: {
    searchValue: '',
  },
  actions: {
    initSearchFacet: function () {
      const filters = getFiltersFromURL();
      state.searchValue = '';
      for (const key in filters) {
        if (filters[key]) {
          const value = filters[key];
          if (key === 's') {
            state.searchValue = value; // Set the state to the search query
          }
          actions.updateFilter({ filterName: key, value });
        }
      }
    },
  },
});
actions.initSearchFacet();
