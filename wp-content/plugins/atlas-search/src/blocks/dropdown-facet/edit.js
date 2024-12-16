/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { InspectorControls, PlainText } from '@wordpress/block-editor';
import { withInstanceId } from '@wordpress/compose';
import { useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { useEntityRecords } from '@wordpress/core-data';

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

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */

export function Edit({
  attributes: { label, formId, className, hasLabel, align },
  instanceId,
  setAttributes,
}) {
  const classes = clsx(
    'wpengine-smart-dropdown-facet',
    align ? 'align' + align : '',
    className,
    { ...useBlockProps() }.className
  );
  useEffect(() => {
    if (!formId) {
      setAttributes({
        formId: `wpengine-smart-dropdown-facet-${instanceId}`,
      });
    }
  }, [formId, setAttributes, instanceId]);

  const { records: categories, isResolving } = useEntityRecords(
    'taxonomy',
    'category'
  );
  return (
    <>
      <InspectorControls key="inspector"></InspectorControls>
      <div {...useBlockProps()} className={classes}>
        {!!hasLabel && (
          <>
            <label
              className="screen-reader-text"
              htmlFor="wpengine-smart-search-dropdown-facet__label"
            >
              {__('Dropdown Label', 'wpengine-smart-search')}
            </label>
            <PlainText
              className="wpengine-smart-search-dropdown-facet__label"
              id="wpengine-smart-search-dropdown-facet__label"
              value={label}
              onChange={(value) => setAttributes({ label: value })}
              style={{ backgroundColor: 'transparent' }}
            />
          </>
        )}

        <div className="wpengine-smart-search-facet__fields">
          <select className="wpengine-smart-dropdown-facet__field">
            <option value="">Please select...</option>
            {categories && categories.length > 0 && !isResolving ? (
              categories.map((category) => (
                <option value={category.name} key={category.name}>
                  {category.name}
                </option>
              ))
            ) : (
              <option value="" disabled>
                {__('No categories available', 'wpengine-smart-search')}
              </option>
            )}
          </select>
        </div>
      </div>
    </>
  );
}

export default withInstanceId(Edit);
