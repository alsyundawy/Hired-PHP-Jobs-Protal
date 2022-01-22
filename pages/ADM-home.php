<?php
$_PMETA = ["load" => [
  ["l", HOST_ASSETS."CB-selector.css"],
  ["s", HOST_ASSETS."CB-selector.js", "defer"],
  ["s", HOST_ASSETS."tinymce/tinymce.min.js", "defer"],
  ["s", HOST_ASSETS."ADM-jobs.js", "defer"]
]];
require PATH_PAGES . "TEMPLATE-atop.php"; ?>
<!-- (A) HEADER -->
<div class="d-flex align-items-center mb-3">
  <h3 class="flex-grow-1">MANAGE JOBS</h3>
  <button class="btn btn-primary mi" onclick="job.addEdit()">
    add
  </button>
</div>

<!-- (B) SEARCH BAR -->
<form class="d-flex align-items-stretch bg-white border mb-3 p-2" onsubmit="return job.search()">
  <input type="text" id="job-search" placeholder="Search" class="form-control form-control-sm"/>
  <button class="btn btn-primary mi">
    search
  </button>
</form>

<!-- (C) JOBS LIST -->
<div id="job-list" class="bg-white zebra my-4"></div>
<?php require PATH_PAGES . "TEMPLATE-abottom.php"; ?>
