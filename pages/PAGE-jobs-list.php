<?php
// (A) GET JOBS
$jobs = $_CORE->autoCall("Jobs", "getAll");

// (B) DRAW JOBS LIST
if (is_array($jobs["data"])) { foreach ($jobs["data"] as $id=>$j) { ?>
<div class="d-flex align-items-center border p-2">
  <div class="flex-grow-1">
    <strong><?=$j["job_title"]?></strong><br>
    <a href="<?=HOST_BASE?>company/<?=$j["company_slug"]?>" target="_blank"><?=$j["company_name"]?></a>
  </div>
  <div>
    <a class="btn btn-primary btn-sm mi" target="_blank" href="<?=HOST_BASE?>job/<?=$id?>">
      zoom_in
    </a>
  </div>
</div>
<?php }} else { ?>
<div class="d-flex align-items-center border p-2">No jobs found.</div>
<?php }

// (C) PAGINATION
$_CORE->load("Page");
$_CORE->Page->draw($jobs["page"], "job.goToPage");
