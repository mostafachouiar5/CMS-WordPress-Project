import React from 'react';

export const useBlockProps = jest
  .fn()
  .mockReturnValue({ className: 'test-block-class' });
export const InspectorControls = ({ children }) => <div>{children}</div>;
export const PlainText = ({ value, onChange, ...props }) => (
  <input {...props} value={value} onChange={(e) => onChange(e.target.value)} />
);
