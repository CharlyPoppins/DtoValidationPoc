<?php

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidSchemaException extends Exception
{
    protected ConstraintViolationListInterface $violations;

    public function getErrorDetails(): array
    {
        return [
            'code' => 422,
            'message' => 'The JSON provided is NOT well formatted',
            'errors' => $this->getViolations(),
        ];
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        $result = [];
        foreach ($this->violations as $violation) {
            $result[$violation->getPropertyPath()] = $violation->getMessage();
        }
        return $result;
    }

    /**
     * @param ConstraintViolationListInterface $violations
     * @return InvalidSchemaException
     */
    public function setViolations(ConstraintViolationListInterface $violations): self
    {
        $this->violations = $violations;

        return $this;
    }
}
