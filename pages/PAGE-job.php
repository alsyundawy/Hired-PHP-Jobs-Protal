<?php
// (A) EXPLODE PATH
$_PATH = explode("/", rtrim($_PATH, "/"));
if (count($_PATH)!=1) { $error = true; }

// (B) GET JOB
if (!isset($error)) {
  $_POST["id"] = $_PATH[0];
  $job = $_CORE->autoCall("Jobs", "get");
  if (!is_array($job)) { $error = true; }
}

// (C) ERROR
if (isset($error)) {
  $_CORE->Route->load("PAGE-404.php", "", 404);
  exit();
}

// (D) JOB PAGE
require PATH_PAGES . "TEMPLATE-top.php"; ?>
<h1><?=$job["job_title"]?></h1>
<div class="mb-3"><?=$job["company_name"]?></div>
<div class="p-3 bg-white border"><?=$job["job_desc"]?></div>
