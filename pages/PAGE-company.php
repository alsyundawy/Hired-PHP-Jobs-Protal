<?php
// (A) EXPLODE PATH
$_PATH = explode("/", rtrim($_PATH, "/"));
if (count($_PATH)!=1) { $error = true; }

// (B) GET COMPANY
if (!isset($error)) {
  $_POST["id"] = $_PATH[0];
  $company = $_CORE->autoCall("Company", "get");
  if (!is_array($company)) { $error = true; }
}

// (C) ERROR
if (isset($error)) {
  $_CORE->Route->load("PAGE-404.php", "", 404);
  exit();
}

// (D) COMPANY PAGE
$_PMETA = ["load" => [
  ["s", HOST_ASSETS."PAGE-company.js", "defer"]
]];
require PATH_PAGES . "TEMPLATE-top.php"; ?>
<!-- (D1) TITLE & DESCRIPTION -->
<h1 class="mb-3"><?=$company["company_name"]?></h1>
<input type="hidden" id="company_id" value="<?=$company["company_id"]?>"/>
<div class="p-3 bg-white border"><?=$company["company_desc"]?></div>

<!-- (D2) JOBS -->
<div id="job-list" class="bg-white zebra my-4"></div>
<?php require PATH_PAGES . "TEMPLATE-bottom.php"; ?>
