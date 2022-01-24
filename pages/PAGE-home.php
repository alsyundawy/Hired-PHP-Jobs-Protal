<?php
$_PMETA = ["load" => [
  ["s", HOST_ASSETS."PAGE-jobs.js", "defer"]
]];
require PATH_PAGES . "TEMPLATE-top.php"; ?>
<!-- (A) SEARCH BAR -->
<h3 class="mb-3">JOBS</h3>
<form class="bg-primary p-4 mb-3 d-flex" onsubmit="return job.search()">
  <input type="text" id="job-search" class="form-control flex-grow-1" placeholder="Find Jobs"/>
  <button class="btn text-white border mi">
    search
  </button>
</form>

<!-- (B) JOBS LIST -->
<div id="job-list" class="bg-white zebra my-4"></div>
<?php require PATH_PAGES . "TEMPLATE-bottom.php"; ?>
