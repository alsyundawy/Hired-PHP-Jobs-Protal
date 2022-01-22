<?php
// (A) GET JOBS
$jobs = $_CORE->autoCall("Jobs", "getAll");

// (B) DRAW JOBS LIST
if (is_array($jobs["data"])) { foreach ($jobs["data"] as $id=>$j) { ?>
<div class="d-flex align-items-center border p-2">
  <div class="flex-grow-1">
    <strong><?=$j["job_title"]?></strong><br>
    <small><?=$j["company_name"]?></small>
  </div>
  <div>
    <button class="btn btn-danger btn-sm mi" onclick="job.del(<?=$id?>)">
      delete
    </button>
    <button class="btn btn-primary btn-sm mi" onclick="job.addEdit(<?=$id?>)">
      edit
    </button>
  </div>
</div>
<?php }} else { ?>
<div class="d-flex align-items-center border p-2">No jobs found.</div>
<?php }

// (C) PAGINATION
$_CORE->load("Page");
$_CORE->Page->draw($jobs["page"], "job.goToPage");
