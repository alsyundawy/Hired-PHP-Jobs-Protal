<?php
// (A) GET COMPANIES
$companies = $_CORE->autoCall("Company", "getAll");

// (B) DRAW COMPANIES LIST
if (is_array($companies["data"])) { foreach ($companies["data"] as $id=>$c) { ?>
<div class="d-flex align-items-center border p-2">
  <div class="flex-grow-1">
    <strong><?=$c["company_name"]?></strong><br>
    <a href="<?=HOST_BASE?>company/<?=$c["company_slug"]?>" target="_blank">
      <?=HOST_BASE?>company/<?=$c["company_slug"]?>
    </a>
  </div>
  <div>
    <button class="btn btn-danger btn-sm mi" onclick="co.del(<?=$id?>)">
      delete
    </button>
    <button class="btn btn-primary btn-sm mi" onclick="co.addEdit(<?=$id?>)">
      edit
    </button>
  </div>
</div>
<?php }} else { ?>
<div class="d-flex align-items-center border p-2">No companies found.</div>
<?php }

// (C) PAGINATION
$_CORE->load("Page");
$_CORE->Page->draw($companies["page"], "co.goToPage");
