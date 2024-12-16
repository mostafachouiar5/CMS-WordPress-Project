import clsx from './clsx';

describe('clsx', () => {
  test.each([
    { input: [], expected: '' },
    { input: ['foo', 'bar', 'baz'], expected: 'foo bar baz' },
    { input: [1, 2, 3], expected: '1 2 3' },
    { input: ['foo', 2, 'bar'], expected: 'foo 2 bar' },
    { input: [['foo', 'bar'], 'baz'], expected: 'foo bar baz' },
    { input: [['foo', ['bar', 'baz']], 'qux'], expected: 'foo bar baz qux' },
    { input: [{ foo: true, bar: false, baz: true }], expected: 'foo baz' },
    {
      input: ['foo', { bar: true, baz: false }, 'qux', ['quux', 'corge']],
      expected: 'foo bar qux quux corge',
    },
    {
      input: ['foo', null, 'bar', undefined, '', 'baz', false, 'qux', 0],
      expected: 'foo bar baz qux',
    },
    {
      input: [['foo', { bar: true, baz: false }], 'qux'],
      expected: 'foo bar qux',
    },
    { input: [[]], expected: '' },
    { input: [[null, false, undefined, '', 0]], expected: '' },
  ])(
    'combines class names correctly with input $input',
    ({ input, expected }) => {
      expect(clsx(...input)).toBe(expected);
    }
  );
});
