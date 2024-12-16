/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { InspectorControls, PlainText } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import { withInstanceId } from '@wordpress/compose';
import { useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

/**
 * Internal dependencies
 */
import clsx from '../utils/clsx';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export function Edit({
  attributes: { label, placeholder, formId, className, hasLabel, align },
  instanceId,
  setAttributes,
}) {
  const classes = clsx(
    'wpengine-smart-search-facet',
    align ? 'align' + align : '',
    className,
    { ...useBlockProps() }.className
  );
  useEffect(() => {
    if (!formId) {
      setAttributes({
        formId: `wpengine-smart-search-facet-${instanceId}`,
      });
    }
  }, [formId, setAttributes, instanceId]);
  return (
    <>
      <InspectorControls key="inspector">
        <PanelBody title={__('Content', 'wpengine-smart-search')} initialOpen>
          <ToggleControl
            label={__('Show search field label', 'wpengine-smart-search')}
            checked={hasLabel}
            onChange={() => setAttributes({ hasLabel: !hasLabel })}
          />
        </PanelBody>
      </InspectorControls>
      <div {...useBlockProps()} className={classes}>
        {!!hasLabel && (
          <>
            <label
              className="screen-reader-text"
              htmlFor="wpengine-smart-search-facet__label"
            >
              {__('Search Label', 'wpengine-smart-search')}
            </label>
            <PlainText
              className="wpengine-smart-search-facet__label"
              id="wpengine-smart-search-facet__label"
              value={label}
              onChange={(value) => setAttributes({ label: value })}
              style={{ backgroundColor: 'transparent' }}
            />
          </>
        )}
        <div className="wpengine-smart-search-facet__fields">
          <TextControl
            className="wpengine-smart-search-facet__field input-control"
            value={placeholder}
            placeholder={__(
              'Enter search placeholder text',
              'wpengine-smart-search'
            )}
            onChange={(value) => setAttributes({ placeholder: value })}
          />
          <button
            type="submit"
            className="wpengine-smart-search-facet__button"
            aria-label={__('Search', 'wpengine-smart-search')}
            onClick={(e) => e.preventDefault()}
            tabIndex={-1}
          >
            Search
          </button>
        </div>
      </div>
    </>
  );
}

export default withInstanceId(Edit);
