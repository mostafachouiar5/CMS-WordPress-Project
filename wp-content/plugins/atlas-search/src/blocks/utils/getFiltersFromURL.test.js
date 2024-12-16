import { getFiltersFromURL } from './getFiltersFromURL';

describe('getFiltersFromURL', () => {
  beforeEach(() => {
    // Mock window.location.origin
    delete window.location;
    window.location = {
      origin: 'http://localhost:8000',
      search: '',
    };
    // Mock window.history.pushState
    window.history.pushState = jest.fn((state, title, url) => {
      const fullUrl = new URL(url, window.location.origin);
      Object.defineProperty(window.location, 'search', {
        value: fullUrl.search,
        writable: true,
      });
    });
  });

  afterEach(() => {
    // Clear mock after each test
    jest.clearAllMocks();
  });

  it('should return an empty object if there are no URL parameters', () => {
    window.history.pushState({}, '', '/');
    const filters = getFiltersFromURL();
    expect(filters).toEqual({});
  });

  it('should correctly parse a single URL parameter', () => {
    window.history.pushState({}, '', '/?category_name=uncategorized');
    const filters = getFiltersFromURL();
    expect(filters).toEqual({ category_name: 'uncategorized' });
  });

  it('should correctly parse multiple URL parameters', () => {
    window.history.pushState(
      {},
      '',
      '/?category_name=uncategorized&tag=javascript'
    );
    const filters = getFiltersFromURL();
    expect(filters).toEqual({
      category_name: 'uncategorized',
      tag: 'javascript',
    });
  });

  it('should handle URL parameters with empty values', () => {
    window.history.pushState({}, '', '/?category_name=&tag=javascript');
    const filters = getFiltersFromURL();
    expect(filters).toEqual({
      category_name: '',
      tag: 'javascript',
    });
  });

  it('should handle URL parameters with special characters', () => {
    window.history.pushState(
      {},
      '',
      '/?category_name=uncategorized&search=react%20hooks'
    );
    const filters = getFiltersFromURL();
    expect(filters).toEqual({
      category_name: 'uncategorized',
      search: 'react hooks',
    });
  });

  it('should handle URL parameters with repeated keys', () => {
    window.history.pushState(
      {},
      '',
      '/?category_name=uncategorized&category_name=javascript'
    );
    const filters = getFiltersFromURL();
    expect(filters).toEqual({
      category_name: 'javascript',
    });
  });
});
