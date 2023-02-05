<?php

namespace App\Framework\Exceptions;

use Exception;

class InvalidFieldValueException extends Exception
{
    private string $fieldName;

    public function __construct(string $message = "", string $fieldName = "")
    {
        $this->fieldName = $fieldName;
        parent::__construct($message, 400);
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}