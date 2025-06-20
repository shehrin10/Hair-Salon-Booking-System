<?php
class Customer {
    public $id, $name, $email;
    public function __construct($id, $name, $email){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
}
?>