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

  // (C) GET COMPANY
  case "get":
    $_CORE->autoGETAPI("Company", "get");
    break;

  // (D) GET OR SEARCH COMPANIES
  case "getAll":
    $_CORE->autoGETAPI("Company", "getAll");
    break;

  // (E) SAVE COMPANY
  case "save":
    $_CORE->autoAPI("Company", "save");
    break;

  // (F) DELETE COMPANY
  case "del":
    $_CORE->autoAPI("Company", "del");
    break;

  // (G) SEARCH COMPANY (FOR AUTOCOMPLETE)
  case "search":
    $_CORE->autoGETAPI("Company", "search");
    break;
}
