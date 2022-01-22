<?php
// (A) ADMIN ONLY
if (!isset($_SESS["user"]) || $_SESS["user"]["user_role"]!="A") {
  $_CORE->respond(0, "Please sign in first", null, null, 403);
}

switch ($_REQ) {
  // (B) INVALID REQUEST
  default:
    $_CORE->respond(0, "Invalid request", null, null, 400);
    break;

  // (C) GET JOB
  case "get":
    $_CORE->autoGETAPI("Jobs", "get");
    break;

  // (D) GET OR SEARCH JOBS
  case "getAll":
    $_CORE->autoGETAPI("Jobs", "getAll");
    break;

  // (E) SAVE JOB
  case "save":
    $_CORE->autoAPI("Jobs", "save");
    break;

  // (F) DELETE JOB
  case "del":
    $_CORE->autoAPI("Jobs", "del");
    break;
}
