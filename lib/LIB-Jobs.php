<?php
class Jobs extends Core {
  // (A) SAVE JOB
  //  $title : job title
  //  $desc : description
  //  $cid : company id
  //  $id : job id, for edit only
  function save ($title, $desc, $cid, $id=null) {
    // (A1) DATA SETUP
    $fields = ["job_title", "job_desc", "company_id"];
    $data = [$title, $desc, $cid];

    // (A2) ADD/UPDATE JOB
    if ($id===null) {
      $this->DB->insert("jobs", $fields, $data);
    } else {
      $data[] = $id;
      $this->DB->update("jobs", $fields, "`job_id`=?", $data);
    }
    return true;
  }

  // (B) DELETE JOB
  //  $id : job id
  function del ($id) {
    $this->DB->update("jobs", ["job_status"], "`job_id`=?", [0, $id]);
    return true;
  }

  // (C) GET JOB
  //  $id : job id
  function get ($id) {
    return $this->DB->fetch(
      "SELECT * FROM `jobs` JOIN `companies` USING (`company_id`) WHERE `job_id`=?",
      [$id]
    );
  }

  // (D) GET ALL OR SEARCH JOBS
  //  $search : optional, job title
  //  $cid : optional, company id
  //  $page : optional, current page number
  function getAll ($search=null, $cid=null, $page=null) {
    // (D1) PARITAL SQL + DATA
    $sql = " WHERE `job_status`=1";
    $data = [];
    if ($search != null) {
      $sql .= " AND `job_title` LIKE ?";
      $data[] = "%$search%";
    }
    if ($cid != null) {
      $sql .= " AND `company_id`=?";
      $data[] = $cid;
    }
    if (count($data)==0) { $data = null; }

    // (D2) PAGINATION
    if ($page != null) {
      $pgn = $this->core->paginator(
        $this->DB->fetchCol("SELECT COUNT(*) FROM `jobs`$sql", $data), $page
      );
      $sql .= " ORDER BY `job_id` DESC LIMIT {$pgn["x"]}, {$pgn["y"]}";
    } else {
      $sql .= " ORDER BY `job_id` DESC";
    }

    // (D3) RESULTS
    $jobs = $this->DB->fetchAll(
      "SELECT j.*, c.`company_name`, c.`company_slug`
       FROM `jobs` `j`
       JOIN `companies` `c` USING (`company_id`)
       $sql", $data, "job_id");
    return $page != null
     ? ["data" => $jobs, "page" => $pgn]
     : $jobs ;
  }
}
