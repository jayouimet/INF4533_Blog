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
    /* Declaration of needed variable for a Field */
    public Model $model;
    public string $attribute;
    public string $type;

    /**
     * Constructor
     *
     * @param [type] $model The model
     * @param string $attribute The attribute from the model
     * @param [type] $type  The type of field
     */ 
    public function __construct(Model $model, string $attribute, string $type = Types::TEXT)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = $type;
    }

    /**
     * Redifining the __toString function to return HTML code
     *
     * @return string
     */
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
