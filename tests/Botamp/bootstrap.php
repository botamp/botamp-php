<?php
// Botamp client
require __DIR__ . '/../../lib/Botamp/Client.php';

// PaginationIterator
require __DIR__ . '/../../lib/Botamp/Utils/PaginationIterator.php';

// Collection
require __DIR__ . '/../../lib/Botamp/Api/BotampObject.php';

// ApiResource
require __DIR__ . '/../../lib/Botamp/Api/ApiResource.php';

// ApiRequestor
require __DIR__ . '/../../lib/Botamp/Api/ApiRequestor.php';

// HttpCodes trait
require __DIR__ . '/../../lib/Botamp/Utils/HttpCodes.php';

// Base Exception
require __DIR__ . '/../../lib/Botamp/Exceptions/Base.php';

// NotAcceptable Exception
require __DIR__ . '/../../lib/Botamp/Exceptions/NotAcceptable.php';

// NotFound Exception
require __DIR__ . '/../../lib/Botamp/Exceptions/NotFound.php';

// Unauthorized Exception
require __DIR__ . '/../../lib/Botamp/Exceptions/Unauthorized.php';

// UnprocessableEntity Exception
require __DIR__ . '/../../lib/Botamp/Exceptions/UnprocessableEntity.php';

// TooManyRequests Exception
require __DIR__ . '/../../lib/Botamp/Exceptions/TooManyRequests.php';

// ApiResponse
require __DIR__ . '/../../lib/Botamp/Api/ApiResponse.php';

require_once 'TestCase.php';
