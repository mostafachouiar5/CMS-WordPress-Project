const baseConfig = require('@wordpress/scripts/config/jest-unit.config.js');

module.exports = {
  ...baseConfig,
  preset: null,
  setupFilesAfterEnv: ['./jest.setup.js'],
  testPathIgnorePatterns: ['/node_modules/', '<rootDir>/tests'],
  testEnvironment: 'jsdom',
  transformIgnorePatterns: ['/node_modules/'],
  transform: {
    '^.+\\.[t|j]sx?$': 'babel-jest', // Transform all .js and .jsx files using babel-jest
  },
  moduleNameMapper: {
    '^react$': require.resolve('../../node_modules/react'),
    '\\.svg$': '<rootDir>/tests/__mocks__/svg.js',
    '\\.(gif|jpg|jpeg|png)$': '<rootDir>/tests/__mocks__/image.js',
    '\\.(css|scss)$': 'identity-obj-proxy',
  },
  coverageReporters: ['clover'],
};
