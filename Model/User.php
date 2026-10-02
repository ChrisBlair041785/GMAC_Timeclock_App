<?php
class User {
    private $ID;
    private $FirstName;
    private $LastName;
    private $Email;
    private $Password;
    private $access;
    private $access_name;
    // Constructor for the User class
    public function __construct($FirstName, $LastName, $Email, $Password, $access, $ID = null, $access_name = null) {
        $this->ID = $ID;
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->Email = $Email;
        $this->Password = $Password;
        $this->access = $access;
        $this->access_name = $access_name;
    }
    // Getters and setters for the User class properties
    public function getID() { return $this->ID; }
    public function setID($value) { $this->ID = $value; }
    public function getFirstName() { return $this->FirstName; }
    public function setFirstName($value) { $this->FirstName = $value; }
    public function getLastName() { return $this->LastName; }
    public function setLastName($value) { $this->LastName = $value; }
    public function getEmail() { return $this->Email; }
    public function setEmail($value) { $this->Email = $value; }
    public function getPassword() { return $this->Password; }
    public function setPassword($value) { $this->Password = $value; }
    public function getAccess() { return $this->access; }
    public function setAccess($value) { $this->access = $value; }
    public function getAccessName() { return $this->access_name; }
    public function setAccessName($value) { $this->access_name = $value; }
}
