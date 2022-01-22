<?php
$_PMETA = ["load" => [
  ["s", HOST_ASSETS."tinymce/tinymce.min.js", "defer"],
  ["s", HOST_ASSETS."ADM-company.js", "defer"]
]];
require PATH_PAGES . "TEMPLATE-atop.php"; ?>
<!-- (A) HEADER -->
<div class="d-flex align-items-center mb-3">
  <h3 class="flex-grow-1">MANAGE COMPANIES</h3>
  <button class="btn btn-primary mi" onclick="co.addEdit()">
    add
  </button>
</div>

<!-- (B) SEARCH BAR -->
<form class="d-flex align-items-stretch bg-white border mb-3 p-2" onsubmit="return co.search()">
  <input type="text" id="co-search" placeholder="Search" class="form-control form-control-sm"/>
  <button class="btn btn-primary mi">
    search
  </button>
</form>

<!-- (C) COMPANIES LIST -->
<div id="co-list" class="bg-white zebra my-4"></div>
<?php require PATH_PAGES . "TEMPLATE-abottom.php"; ?>
