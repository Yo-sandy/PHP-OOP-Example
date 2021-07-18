<?php
    abstract class Person
    {
        protected $name, $fname, $contactNo, $city, $state;

        abstract public function  setData($name, $fname, $contactNo, $city, $state);
        abstract public function getData();
    }

    class Employee extends Person
    {
        public function setData($name, $fname, $contactNo, $city, $state)
        {
            $this->name = $name;
            $this->fname = $fname;
            $this->contactNo = $contactNo;
            $this->city = $city;
            $this->state = $state;
        }

        public function display()
        {
            echo "Name: " .$this->name ."<br>";
            echo "Father Name: " .$this->fname ."<br>";
            echo "Contact No: " .$this->contactNo ."<br>";
            echo "City: " .$this->city ."<br>";
            echo "State: " .$this->state ."<br>";
        }
        public function getData() {}
    }
    $rahul = new Employee;
    $rahul->setData('sohanlal', 'mohanlal',9898989898,'Flana','Rajsthan');
    $rahul->display();