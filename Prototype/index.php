<?php

        include_once "Designing.php";
        include_once "Development.php";
        include_once "Marketing.php";

        class Client
        {
            private $designing;
            private $development;
            private $marketing;

            public function  __construct()
            {
                $this->initProto();

                $manjeetDesigner = clone $this->designing;
                $manjeetDesigner->setDetails("Manjeet", "App Designer");

                $sandeepDesigner = clone $this->designing;
                $sandeepDesigner->setDetails("Sandeep", "Web Designer");

                var_dump($manjeetDesigner->getName());
                var_dump($manjeetDesigner->getDepartment());  echo "<br/>";

                var_dump($sandeepDesigner->getName());
                var_dump($sandeepDesigner->getDepartment()); echo "<br/>";
            }
            public function initProto()
            {
                $this->marketing = new Marketing();
                $this->designing = new Designing();
                $this->development = new Development();
            }
        }

        $worker = new Client();
