import { updateURL } from './facets.store';
// Mocking @wordpress/interactivity module
jest.mock('@wordpress/interactivity', () => ({
  store: () => ({ state: jest.fn() }),
  getElement: jest.fn(),
}));

describe('updateURL function', () => {
  beforeEach(() => {
    // Mock window.location.origin and window.location.assign
    delete window.location;
    window.location = {
      origin: 'http://localhost:8000',
      assign: jest.fn(),
    };
  });

  afterEach(() => {
    jest.clearAllMocks();
  });

  it('should update the URL with given parameters', async () => {
    const params = {
      category_name: 'uncategorized',
      search: 'example',
    };

    await updateURL(params);

    expect(window.location.assign).toHaveBeenCalledWith(
      'http://localhost:8000/?category_name=uncategorized&search=example'
    );
  });

  it('should handle undefined and null values in parameters', async () => {
    const params = {
      category_name: 'uncategorized',
      search: null,
      anotherParam: undefined,
    };

    await updateURL(params);

    // Should only include 'category_name' in the URL
    expect(window.location.assign).toHaveBeenCalledWith(
      'http://localhost:8000/?category_name=uncategorized'
    );
  });

  it('should handle empty parameters', async () => {
    await updateURL({});

    expect(window.location.assign).toHaveBeenCalledWith(
      'http://localhost:8000/'
    );
  });

  it('should handle parameters with empty strings', async () => {
    const params = {
      category_name: '',
      search: 'test',
    };

    await updateURL(params);

    // Should set category_name to an empty string and include 'search' in the URL
    expect(window.location.assign).toHaveBeenCalledWith(
      'http://localhost:8000/?category_name=&search=test'
    );
  });
});
