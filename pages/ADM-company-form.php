<?php
// (A) GET COMPANY
$edit = isset($_POST["id"]) && $_POST["id"]!="";
if ($edit) {
  $company = $_CORE->autoCall("Company", "get");
}

// (B) COMPANY FORM ?>
<h3 class="mb-3"><?=$edit?"EDIT":"ADD"?> COMPANY</h3>
<form onsubmit="return co.save()">
  <input type="hidden" id="company_id" value="<?=isset($company)?$company["company_id"]:""?>"/>

  <div class="bg-white border p-4 mb-3">
    <h5 class="mb-3">BASIC INFO</h5>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text mi">person</span>
      </div>
      <input type="text" class="form-control" id="company_name" required value="<?=isset($company)?$company["company_name"]:""?>" placeholder="Name"/>
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text mi">link</span>
      </div>
      <input type="text" class="form-control" id="company_slug" required value="<?=isset($company)?$company["company_slug"]:""?>" placeholder="URL Slug"/>
    </div>
  </div>

  <div class="bg-white border p-4 mb-3">
    <h5 class="mb-3">COMPANY DESCRIPTION</h5>
    <textarea id="company_desc">
      <?=isset($company)?$company["company_desc"]:""?>
    </textarea>
  </div>

  <input type="button" class="col btn btn-danger btn-lg" value="Back" onclick="cb.page(1)"/>
  <input type="submit" class="col btn btn-primary btn-lg" value="Save"/>
</form>
