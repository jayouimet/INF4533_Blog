<?php

abstract class Types
{
    const TEXT = "text";
    const NUMBER = "number";
    const EMAIL = "email";
    const PASSWORD = "password";
}

class Field
{
    public Model $model;
    public string $attribute;
    public string $type;

    public function __construct($model, string $attribute, string $type = Types::TEXT)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = $type;
    }

    public function __toString()
    {
        return sprintf('
                <tr>
                    <td>%s</td>
                    <td><input type="%s" name="%s" value="%s"></td>
                    <td style="color:red;">%s</td>
                </tr>
            ',
            $this->attribute,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->getFirstError($this->attribute)
        );
    }
}
