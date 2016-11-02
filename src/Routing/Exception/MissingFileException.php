<?php
namespace App\Routing\Exception;

use Cake\Core\Exception\Exception;

/**
 * Exception raised when a file path doesn't exist.
 */
class MissingFileException extends Exception
{

    /**
     * {@inheritDoc}
     */
    protected $_messageTemplate = 'The Route file "%s" could not be found.';
}
