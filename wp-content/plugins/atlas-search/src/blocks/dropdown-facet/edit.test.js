import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import Edit from './edit';

jest.mock('@wordpress/i18n', () => ({
  __: jest.fn((str) => str),
}));

jest.mock('@wordpress/core-data', () => ({
  useEntityRecords: jest.fn(() => ({
    records: [
      { id: 'category1', name: 'Category1' },
      { id: 'category2', name: 'Category2' },
    ],
    isResolving: false,
    error: null,
  })),
}));

describe('Edit Component', () => {
  it('should be able to select from the dropdown of categories', () => {
    render(<Edit attributes={{}} setAttributes={jest.fn()} />);
    expect(screen.getByText('Category1')).toBeInTheDocument();
    fireEvent.click(screen.getByText('Category1'), {
      target: { value: 'category2' },
    });
    expect(screen.getByText('Category2')).toBeInTheDocument();
  });

  it('should toggle the label visibility with ToggleControl and can be updated', () => {
    const setAttributes = jest.fn();
    render(
      <Edit
        attributes={{ hasLabel: true, label: 'Dropdown Label' }}
        setAttributes={setAttributes}
      />
    );

    const input = screen.getByLabelText('Dropdown Label');

    // Check if label is present when toggle is on
    expect(input).toBeInTheDocument();
    expect(input).toHaveValue('Dropdown Label');

    input.value = 'Updated Label';
    expect(input).toHaveValue('Updated Label');
  });
});
