import { store, getElement } from '@wordpress/interactivity';
import { config } from '../config';

export const updateURL = async (params) => {
  const baseUrl = `${window.location.origin}/`;
  const url = new URL(baseUrl);

  // Set search parameters
  Object.keys(params).forEach((key) => {
    if (params[key] !== undefined && params[key] !== null) {
      url.searchParams.set(key, params[key]);
    }
  });
  window.location.assign(url.toString());
};

const FACETS_STORE_KEY = '__wpengine-smart-search_FacetsStoreInstance__';

// Method to get the singleton instance
export function getInstance() {
  return globalThis[FACETS_STORE_KEY];
}

// Method to set the singleton instance
export function setInstance(instance) {
  globalThis[FACETS_STORE_KEY] = instance;
}

export const getFacetsStore = () => {
  if (!getInstance()) {
    setInstance(
      store(config.facetsStoreName, {
        state: {
          filters: [],
          get allFilters() {
            return JSON.stringify(getInstance().state.filters);
          },
        },
        actions: {
          updateFilter({ filterName, value }) {
            getInstance().state.filters[filterName] = value;
          },
          setSearchValue() {
            const { ref } = getElement();
            const { value } = ref;
            getInstance().state.searchValue = value;
          },
          *performSearch(e) {
            e.preventDefault();
            const params = {
              ...getInstance().state.filters,
              s: getInstance().state.searchValue,
            };
            yield updateURL(params);
          },
        },
      })
    );
  }
  return getInstance();
};
getFacetsStore();
