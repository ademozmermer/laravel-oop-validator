<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator;

use Closure;

/**
 * Class ValidationBuilder
 * @package KrzysztofRewak\LaravelOOPValidator
 */
class ValidationBuilder
{
    /** @var string[] */
    protected $rules = [];

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param string $fieldName
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validate(string $fieldName, Closure $lambda): ValidationBuilder
    {
        $field = $this->createNewField();
        $lambda->call($field, $field);

        $this->rules[$fieldName] = $field->getRules();
        return $this;
    }

    /**
     * @param string $array
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validateEach(string $array, Closure $lambda): ValidationBuilder
    {
        $this->validate("$array.*", $lambda);
        return $this;
    }

    /**
     * @param string $field
     * @param string $array
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validateInEach(string $field, string $array, Closure $lambda): ValidationBuilder
    {
        $this->validate("$array.*.$field", $lambda);
        return $this;
    }

    /**
     * @return Contracts\Field
     */
    protected function createNewField(): Contracts\Field
    {
        return new Field();
    }
}