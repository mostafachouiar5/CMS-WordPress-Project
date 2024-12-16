import React from 'react';

export const PanelBody = ({ title, children }) => (
  <div className="panel-body">
    <h2>{title}</h2>
    {children}
  </div>
);

export const TextControl = ({ value, onChange, ...props }) => (
  <input
    type="text"
    {...props}
    value={value}
    onChange={(e) => onChange(e.target.value)}
  />
);

export const ToggleControl = ({ checked, onChange, label }) => (
  <label className="toggle-control">
    <input
      type="checkbox"
      checked={checked}
      onChange={() => onChange(!checked)}
    />
    {label}
  </label>
);
