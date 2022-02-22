<?php
require_once dirname(__FILE__) . "/Field.php";

class Form {
    /**
     * Begin a form
     *
     * @param string $action Action for the form
     * @param string $method Method of the form (GET/POST)
     * @return Form Returns the form
     */
    public static function begin(string $action,string $method) : Form{
        echo sprintf('<form action="%s" method="%s">',$action,$method);
        return new Form();
    }

    /**
     * To end the form
     *
     * @return void
     */
    public static function end(){
        echo '</form>';
    }

    /**
     * Create a field from the model, attribute, type of field
     *
     * @param Model $model
     * @param string $attribute
     * @param string $type
     * @return Field    The field
     */
    public function field(Model $model,string $attribute,string $type = Types::TEXT) : Field{
        return new Field($model, $attribute, $type);
    }
}

?>