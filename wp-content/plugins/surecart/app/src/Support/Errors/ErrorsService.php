<?php

namespace SureCart\Support\Errors;

/**
 * Handles error translations from the API.
 */
class ErrorsService {
	/**
	 * Translations for error codes.
	 */
	public function translate( $response = null, $code = null ) {
		$translations = new ErrorsTranslationService();
		return $translations->translate( $response, $code );
	}
}
