<?php
class Student {
    private $StudID;
    private $FirstName;
    private $LastName;
    private $School;

    public function __construct($FirstName, $LastName, $School, $StudID = null) {
        $this->StudID = $StudID;
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->School = $School;
    }

    public function getStudID() { return $this->StudID; }
    public function setStudID($value) { $this->StudID = $value; }
    public function getFirstName() { return $this->FirstName; }
    public function setFirstName($value) { $this->FirstName = $value; }
    public function getLastName() { return $this->LastName; }
    public function setLastName($value) { $this->LastName = $value; }
    public function getSchool() { return $this->School; }
    public function setSchool($value) { $this->School = $value; }
}
