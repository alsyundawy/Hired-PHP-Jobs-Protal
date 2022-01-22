<?php
// (A) LOAD CORE ENGINE
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "CORE-go.php";
$_CORE->load("Route");

// (B) MANUAL ROUTES
$_CORE->Route->set([
  "admin/*" => "ADM-index.php",     // admin panel
  "company/*" => "PAGE-company.php" // company info page
]);

// (C) AUTO RESOLVE ROUTE
$_CORE->Route->run();
