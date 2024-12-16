<?php

namespace AtlasSearch\Index;

use Wpe_Content_Engine\Helper\Exceptions\ClientQueryGraphqlErrorsException;

const BATCH_SIZE                 = 250;
const BATCH_SIZE_SEMANTIC_SEARCH = 10;

function get_batch_size() {
	try {
		$config = \AtlasSearch\Index\get_semantic_search_config( true );
	} catch ( ClientQueryGraphqlErrorsException $e ) {
		if ( $e->is_access_ai_powered_search_error() ) {
			return BATCH_SIZE;
		}
		throw $e;
	}

	if ( empty( $config ) ) {
		return BATCH_SIZE;
	}

	if ( isset( $config['enabled'] ) && $config['enabled'] ) {
		return BATCH_SIZE_SEMANTIC_SEARCH;
	}

	return BATCH_SIZE;
}
