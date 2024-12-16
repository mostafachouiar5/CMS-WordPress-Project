import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import Edit from './edit';

jest.mock('@wordpress/i18n', () => ({
  __: jest.fn((str) => str),
}));

describe('Edit Component', () => {
  it('should render the block with the correct className', () => {
    render(<Edit attributes={{}} setAttributes={jest.fn()} />);
    expect(screen.getByRole('button', { name: /Search/i })).toHaveClass(
      'wpengine-smart-search-facet__button'
    ); // Update this to the correct class if necessary
  });

  it('should render InspectorControls with ToggleControl', () => {
    render(<Edit attributes={{}} setAttributes={jest.fn()} />);
    expect(screen.getByText('Content')).toBeInTheDocument();
    expect(screen.getByRole('checkbox')).toBeInTheDocument();
  });

  it('should toggle the label visibility with ToggleControl', () => {
    const setAttributes = jest.fn();
    render(
      <Edit
        attributes={{ hasLabel: true, label: 'Search Label' }}
        setAttributes={setAttributes}
      />
    );

    // Check if label is present when toggle is on
    expect(screen.getByLabelText('Search Label')).toBeInTheDocument();

    // Toggle off
    fireEvent.click(screen.getByRole('checkbox'));
    expect(setAttributes).toHaveBeenCalledWith({ hasLabel: false });
  });

  it('should update the label value in PlainText', () => {
    const setAttributes = jest.fn();
    render(
      <Edit
        attributes={{ label: 'Test Label', placeholder: 'Test Placeholder' }}
        setAttributes={setAttributes}
      />
    );

    const input = screen.getByPlaceholderText('Enter search placeholder text'); // Ensure this matches your component's placeholder
    fireEvent.change(input, { target: { value: 'Updated Label' } });

    // Check that setAttributes is called twice
    expect(setAttributes).toHaveBeenCalledTimes(2);

    // Verify the first call
    expect(setAttributes).toHaveBeenNthCalledWith(1, {
      formId: expect.any(String), // Match any string for formId
    });

    // Verify the second call
    expect(setAttributes).toHaveBeenNthCalledWith(2, {
      placeholder: 'Updated Label',
    });
  });

  it('should render TextControl for placeholder', () => {
    render(
      <Edit
        attributes={{ placeholder: 'Search posts...' }}
        setAttributes={jest.fn()}
      />
    );
    expect(
      screen.getByPlaceholderText('Enter search placeholder text')
    ).toBeInTheDocument();
  });
});
