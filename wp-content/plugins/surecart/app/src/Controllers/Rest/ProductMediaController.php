<?php

namespace SureCart\Controllers\Rest;

use SureCart\Models\ProductMedia;

/**
 * Handle ProductMedia requests through the REST API
 */
class ProductMediaController extends RestController {
	/**
	 * Always fetch with these subcollections.
	 *
	 * @var array
	 */
	protected $with = [ 'media' ];

	/**
	 * Class to make the requests.
	 *
	 * @var string
	 */
	protected $class = ProductMedia::class;

	/**
	 * Download a media file.
	 *
	 * @param \WP_REST_Request $request Request object.
	 *
	 * @return integer|\WP_Error
	 */
	public function download( \WP_REST_Request $request ) {
		$model = $this->middleware( new $this->class(), $request );
		if ( is_wp_error( $model ) ) {
			return $model;
		}

		$media = $model->with( [ 'media' ] )->find( $request['id'] );

		if ( is_wp_error( $media ) ) {
			return $media;
		}

		$attachment_id = $media->download();

		if ( is_wp_error( $attachment_id ) ) {
			return $attachment_id;
		}

		return $attachment_id;
	}
}
