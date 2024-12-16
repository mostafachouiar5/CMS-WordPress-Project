export function getFiltersFromURL() {
  const filters = {};
  const urlParams = new URLSearchParams(window.location.search);

  urlParams.forEach((value, key) => {
    filters[key] = value;
  });
  return filters;
}
