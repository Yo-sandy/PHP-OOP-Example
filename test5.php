<?php
    include_once "TextFactory.php";

   class test5
   {
       public function __construct()
       {
           $tf = new TextFactory();
           echo $tf->startFactory();
       }
   }

   $ClientWorker = new test5();