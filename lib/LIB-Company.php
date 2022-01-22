<?php
class Company extends Core {
  // (A) SAVE COMPANY
  //  $slug : url slug
  //  $name : company name
  //  $desc : company description
  //  $id : company id, for edit only
  function save ($slug, $name, $desc=null, $id=null) {
    // (A1) DATA SETUP
    $fields = ["company_slug", "company_name", "company_desc"];
    $data = [$slug, $name, $desc];

    // (A2) ADD/UPDATE COMPANY
    if ($id===null) {
      $this->DB->insert("companies", $fields, $data);
    } else {
      $data[] = $id;
      $this->DB->update("companies", $fields, "`company_id`=?", $data);
    }
    return true;
  }

  // (B) DELETE COMPANY
  //  $id : company id
  function del ($id) {
    $this->DB->start();
    $this->DB->delete("jobs", "`company_id`=?", [$id]);
    $this->DB->delete("companies", "`company_id`=?", [$id]);
    $this->DB->end();
    return true;
  }

  // (C) GET COMPANY
  //  $id : company id or slug
  function get ($id) {
    return $this->DB->fetch(
      "SELECT * FROM `companies` WHERE `company_".(is_numeric($id)?"id":"slug")."`=?",
      [$id]
    );
  }

  // (D) GET ALL OR SEARCH COMPANIES
  //  $search : optional, company name
  //  $page : optional, current page number
  function getAll ($search=null, $page=null) {
    // (D1) PARITAL SQL + DATA
    $sql = "FROM `companies`";
    $data = null;
    if ($search != null) {
      $sql .= " WHERE `company_name` LIKE ?";
      $data = ["%$search%"];
    }

    // (D2) PAGINATION
    if ($page != null) {
      $pgn = $this->core->paginator(
        $this->DB->fetchCol("SELECT COUNT(*) $sql", $data), $page
      );
      $sql .= " LIMIT {$pgn["x"]}, {$pgn["y"]}";
    }

    // (D3) RESULTS
    $companies = $this->DB->fetchAll("SELECT * $sql", $data, "company_id");
    return $page != null
     ? ["data" => $companies, "page" => $pgn]
     : $companies ;
  }

  // (E) SEARCH COMPANY - FOR AUTOCOMPLETE USE
  //  $search : company name
  function search ($search) {
    $sql = "SELECT * FROM `companies` WHERE `company_name` LIKE ?";
    $data = ["%$search%"];
    $this->DB->query($sql, $data);
    $result = [];
    while ($row = $this->DB->stmt->fetch()) {
      $result[] = [
        "d" => $row["company_name"],
        "v" => $row["company_id"]
      ];
    }
    return count($result)==0 ? null : $result;
  }
}
