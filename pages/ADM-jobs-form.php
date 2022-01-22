<?php
// (A) GET JOB
$edit = isset($_POST["id"]) && $_POST["id"]!="";
if ($edit) {
  $job = $_CORE->autoCall("Jobs", "get");
}

// (B) JOB FORM ?>
<h3 class="mb-3"><?=$edit?"EDIT":"ADD"?> JOB</h3>
<form onsubmit="return job.save()">
  <input type="hidden" id="job_id" value="<?=isset($job)?$job["job_id"]:""?>"/>

  <div class="bg-white border p-4 mb-3">
    <h5 class="mb-3">BASIC INFO</h5>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text mi">work</span>
      </div>
      <input type="text" class="form-control" id="job_title" required value="<?=isset($job)?$job["job_title"]:""?>" placeholder="Job Title"/>
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text mi">business</span>
      </div>
      <input type="text" class="form-control" id="company_name" required<?=isset($job)?" readOnly":""?>
             value="<?=isset($job)?$job["company_name"]:""?>" placeholder="Company Name"/>
      <button id="company_unlock" type="button"
              class="btn btn-primary mi<?=isset($job)?"":" d-none"?>" onclick="job.unlock()">
        published_with_changes
      </button>
      <input type="hidden" id="company_id" value="<?=isset($job)?$job["company_id"]:""?>"/>
    </div>
  </div>

  <div class="bg-white border p-4 mb-3">
    <h5 class="mb-3">JOB DESCRIPTION</h5>

    <textarea id="job_desc" required>
      <?=isset($job)?$job["job_desc"]:""?>
    </textarea>
  </div>

  <input type="button" class="col btn btn-danger btn-lg" value="Back" onclick="cb.page(1)"/>
  <input type="submit" class="col btn btn-primary btn-lg" value="Save"/>
</form>
