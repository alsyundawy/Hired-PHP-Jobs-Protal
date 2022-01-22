<?php
// (A) FOR ADMIN ONLY
if (!isset($_SESS["user"]) || $_SESS["user"]["user_role"]!="A") {
  $_CORE->redirect();
}

// (B) AUTO RESOLVE PATH
$_CORE->Route->pathload ($_PATH, "ADM");
