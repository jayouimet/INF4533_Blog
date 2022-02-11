<?php
require_once "../src/Model.php";

class UserModel extends Model {
    public string $firstname = '';
    public string $lastname = '';
    public string $password = '';
    public string $passwordConfirm = '';
    public int $age = 0;

    public function rules(): array {
        return [
            'firstname' => [Rules::REQUIRED],
            'lastname' => [Rules::REQUIRED],
            'age' => [Rules::REQUIRED, [Rules::MIN_VAL, 'min' => 1], [Rules::MAX_VAL, 'max' => 200]],
            'password' => [Rules::REQUIRED, [Rules::MIN, 'min' => 8]],
            'passwordConfirm' => [Rules::REQUIRED, [Rules::MATCH, 'match' => 'password']],
        ];
    }

    public function register(){
        // new user created
        return true;
    }
}
?>