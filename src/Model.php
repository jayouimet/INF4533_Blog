<?php

/**
 * Database rules for attributes
 */
abstract class Rules
{
    const REQUIRED = 0;
    const EMAIL = 1;
    const MATCH = 2;
    const MIN = 3;
    const MAX = 4;
    const MIN_VAL = 5;
    const MAX_VAL = 6;
}

/**
 * The Model class represents a table in the Database.
 * You need to extend from this class to define a "Model"
 */
abstract class Model
{
    public array $errors = [];
    
    /**
     * Load the data received from the database
     *
     * @param array $data   The array of all attributes and values
     * @return void
     */
    public function loadData(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * List of rules for specific attributes
     *
     * @return array    The rules
     */
    abstract public function rules(): array;

    /**
     * Function that validates the attributes to respect the rules set in the rules() function
     *
     * @return bool Return true if there's no error in the attributes of the model
     */
    public function validate() : bool
    {
        /* Get all the rules */
        foreach ($this->rules() as $attribute => $rules) {
            /* Get the value of the attributes in the model */
            $value = $this->{$attribute};
            // Check if the attribute value passes the rules
            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (!is_int($ruleName)) {
                    $ruleName = $rule[0];
                }
                $this->checkRules($ruleName, $value, $rule, $attribute);
            }
        }
        return empty($this->errors);
    }

    /**
     * Simple function to check whether an attribute is conform to the rules or not.
     * If there's an error of validation, add the error in the errors array of Model.
     * 
     * @return void
     */
    private function checkRules($ruleName, $value, $rule, $attribute)
    {
        if (($ruleName === Rules::REQUIRED && strlen($value) == 0)  ||
            ($ruleName === Rules::EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) ||
            ($ruleName === Rules::MIN && strlen($value) < $rule['min']) ||
            ($ruleName === Rules::MAX && strlen($value) > $rule['max']) ||
            ($ruleName === Rules::MIN_VAL && $value < $rule['min']) ||
            ($ruleName === Rules::MAX_VAL && $value > $rule['max']) ||
            ($ruleName === Rules::MATCH && $value !== $this->{$rule['match']})
        ) {
            $this->addError($attribute, $ruleName, $rule);
        }
    }

    /**
     * Function to add an error message if an attribute isn't conform to the rules.
     *
     * @param string $attribute
     * @param string $rule
     * @param array $params
     * @return void
     */
    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';

        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $message = str_replace(sprintf('{%s}', $key), $value, $message);
            }
        }

        $this->errors[$attribute][] = $message;
    }

    /**
     * Return an array of error messages for each type of attribute
     *
     * @return array
     */
    private function errorMessages() : array
    {
        return [
            Rules::EMAIL => 'This field must be a valid email address',
            Rules::MIN => 'Min length of this field must be {min}',
            Rules::MAX => 'Max length of this field must be {max}',
            Rules::MIN_VAL => 'Min value of this field must be {min}',
            Rules::MAX_VAL => 'Max value of this field must be {max}',
            Rules::MATCH => 'This field must be the same as {match}',
            Rules::REQUIRED => 'This field is required',
        ];
    }

    /**
     * To get the first error in the Model
     *
     * @param string $attribute
     * @return string
     */
    public function getFirstError(string $attribute) : string
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
