<?php

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

abstract class Model
{
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public array $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
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

    private function errorMessages()
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

    public function getFirstError(string $attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
