<?php

namespace Wpe_Content_Engine\Helper\Exceptions;

class ClientQueryException extends \ErrorException {}

class ClientQueryGraphqlErrorsException extends ClientQueryException {
	public function is_access_ai_powered_search_error(): bool {
		return strpos( $this->getMessage(), 'To access this feature, you must upgrade to AI-Powered Search.' ) !== false;
	}
}
