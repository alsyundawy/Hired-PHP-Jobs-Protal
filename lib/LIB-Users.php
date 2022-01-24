<?php
class Users extends Core {
  // (A) PASSWORD CHECKER
  //  $password : password to check
  //  $pattern : regex pattern check (at least 8 characters, alphanumeric)
  function checker ($password, $pattern='/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/i') {
    if (preg_match($pattern, $password)) { return true; }
    else {
      $this->error = "Password must be at least 8 characters alphanumeric.";
      return false;
    }
  }

  // (B) ADD OR UPDATE USER
  //  $name : user name
  //  $email : user email
  //  $password : user password
  //  $role : user role - "A"dmin | "U"ser
  //  $id : user id (for updating only)
  function save ($name, $email, $password, $role="U", $id=null) {
    // (B1) DATA SETUP + PASSWORD CHECK
    if (!$this->checker($password)) { return false; }
    $fields = ["user_name", "user_email", "user_role", "user_password"];
    $data = [$name, $email, $role, password_hash($password, PASSWORD_DEFAULT)];

    // (B2) ADD/UPDATE USER
    if ($id===null) {
      $this->DB->insert("users", $fields, $data);
    } else {
      $data[] = $id;
      $this->DB->update("users", $fields, "`user_id`=?", $data);
    }
    return true;
  }

  // (C) REGISTER USER - RESTRICTED VERSION OF "SAVE" FOR FRONT-END
  //  $name : user name
  //  $email : user email
  //  $password : user password
  function register ($name, $email, $password) {
    // (C1) ALREADY SIGNED IN
    global $_SESS;
    if (isset($_SESS["user"])) {
      $this->error = "You are already signed in.";
      return false;
    }

    // (C2) CHECK USER EXIST
    if (is_array($this->get($email))) {
      $this->error = "$email is already registered.";
      return false;
    }

    // (C3) SAVE
    $this->save($name, $email, $password);

    // (C4) ACTIVATE SESSION
    // LAST_ID SOMEHOW MISSES SOMETIMES, SAFER TO USE "FETCH BY EMAIL"
    $_SESS["user"] = $this->get($email);
    $this->core->Session->create();
    return true;
  }

  // (D) "LIMITED SAVE" - FOR MY ACCOUNT
  function saveL ($password) {
    // (D1) MUST BE SIGNED IN
    global $_SESS;
    if (!isset($_SESS["user"])) {
      $this->error = "Please sign in first";
      return false;
    }

    // (D2) UPDATE ACCOUNT
    return $this->save(
      $_SESS["user"]["user_name"], $_SESS["user"]["user_email"],
      $password, $_SESS["user"]["user_role"], $_SESS["user"]["user_id"]
    );
  }

  // (E) DELETE USER
  //  $id : user id
  function del ($id) {
    $this->DB->delete("users", "`user_id`=?", [$id]);
    return true;
  }

  // (F) GET USER
  //  $id : user id or email
  function get ($id) {
    return $this->DB->fetch(
      "SELECT * FROM `users` WHERE `user_". (is_numeric($id)?"id":"email") ."`=?",
      [$id]
    );
  }

  // (G) GET ALL OR SEARCH USERS
  //  $search : optional, user name or email
  //  $role : optional, restrict to this role only
  //  $page : optional, current page number
  function getAll ($search=null, $role=null, $page=null) {
    // (G1) PARITAL USERS SQL + DATA
    $sql = "FROM `users`";
    $data = null;
    if ($search != null || $role != null) {
      $sql .= " WHERE";
      $data = [];
      if ($search != null) {
        $sql .= " (`user_name` LIKE ? OR `user_email` LIKE ?)";
        array_push($data, "%$search%", "%$search%");
      }
      if ($role != null) {
        $sql .= ($search==null?"":" AND") . " `user_role`=?";
        $data[] = $role;
      }
    }

    // (G2) PAGINATION
    if ($page != null) {
      $pgn = $this->core->paginator(
        $this->DB->fetchCol("SELECT COUNT(*) $sql", $data), $page
      );
      $sql .= " LIMIT {$pgn["x"]}, {$pgn["y"]}";
    }

    // (G3) RESULTS
    $users = $this->DB->fetchAll("SELECT * $sql", $data, "user_id");
    return $page != null
     ? ["data" => $users, "page" => $pgn]
     : $users ;
  }

  // (H) VERIFY EMAIL & PASSWORD (LOGIN OR SECURITY CHECK)
  // RETURNS USER ARRAY IF VALID, FALSE IF INVALID
  //  $email : user email
  //  $password : user password
  function verify ($email, $password) {
    // (H1) GET USER
    $user = $this->get($email);
    $pass = is_array($user);

    // (H2) PASSWORD CHECK
    if ($pass) {
      $pass = password_verify($password, $user["user_password"]);
    }

    // (H3) RESULTS
    if (!$pass) {
      $this->error = "Invalid user or password.";
      return false;
    }
    return $user;
  }

  // (I) LOGIN
  //  $email : user email
  //  $password : user password
  function login ($email, $password) {
    // (I1) ALREADY SIGNED IN
    global $_SESS;
    if (isset($_SESS["user"])) { return true; }

    // (I2) VERIFY EMAIL PASSWORD
    $user = $this->verify($email, $password);
    if ($user===false) { return false; }

    // (I3) SESSION START
    $_SESS["user"] = $user;
    $this->core->Session->create();
    return true;
  }

  // (J) LOGOUT
  function logout () {
    // (J1) ALREADY SIGNED OFF
    global $_SESS;
    if (!isset($_SESS["user"])) { return true; }

    // (J2) END SESSION
    $this->core->Session->destroy();
    return true;
  }
}
