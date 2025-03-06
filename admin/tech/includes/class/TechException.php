<?php

namespace Admin\Tech\Includes\Class;

class Exception extends \Exception
{
    public function __construct($property)
    {
        $message = "The property '$property' does not exist.";
        $code = 0; // Custom exception code (default is 0)
        parent::__construct($message, $code);
    }

    public function logError()
    {
        // Here you can log the error message to a file, for example
        error_log($this->getMessage(), 3, 'errors.log');
    }
}
