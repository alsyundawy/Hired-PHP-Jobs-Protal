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
  //  $page : optional, current page number
  function getAll ($search=null, $page=null) {
    // (D1) PARITAL SQL + DATA
    $sql = " WHERE `job_status`=1";
    $data = null;
    if ($search != null) {
      $sql .= " AND `job_title` LIKE ?";
      $data = ["%$search%"];
    }

    // (D2) PAGINATION
    if ($page != null) {
      $pgn = $this->core->paginator(
        $this->DB->fetchCol("SELECT COUNT(*) FROM `jobs`$sql", $data), $page
      );
      $sql .= " LIMIT {$pgn["x"]}, {$pgn["y"]}";
    }

    // (D3) RESULTS
    $jobs = $this->DB->fetchAll(
      "SELECT j.*, c.`company_name`
       FROM `jobs` `j`
       JOIN `companies` `c` USING (`company_id`)
       $sql", $data, "job_id");
    return $page != null
     ? ["data" => $jobs, "page" => $pgn]
     : $jobs ;
  }
}
