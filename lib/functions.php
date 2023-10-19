<?php
require_once(__DIR__ . "/db.php");
$BASE_PATH = '/';




function reset_session()
{
    session_unset();
    session_destroy();
    session_start();
}



function get_columns($table)
{
    $table = se($table, null, null, false);
    $db = getDB();
    $query = "SHOW COLUMNS from $table"; //be sure you trust $table
    $stmt = $db->prepare($query);
    $results = [];
    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<pre>" . var_export($e, true) . "</pre>";
    }
    return $results;
}



function save_data($table, $data, $ignore = ["submit"])
{
    $table = se($table, null, null, false);
    $db = getDB();
    $query = "INSERT INTO $table "; //be sure you trust $table
    //https://www.php.net/manual/en/functions.anonymous.php Example#3
    $columns = array_filter(array_keys($data), function ($x) use ($ignore) {
        return !in_array($x, $ignore); // $x !== "submit";
    });
    //arrow function uses fn and doesn't have return or { }
    //https://www.php.net/manual/en/functions.arrow.php
    $placeholders = array_map(fn ($x) => ":$x", $columns);
    $query .= "(" . join(",", $columns) . ") VALUES (" . join(",", $placeholders) . ")";

    $params = [];
    foreach ($columns as $col) {
        $params[":$col"] = $data[$col];
    }
    $stmt = $db->prepare($query);
    try {
        $stmt->execute($params);
        //https://www.php.net/manual/en/pdo.lastinsertid.php
        //echo "Successfully added new record with id " . $db->lastInsertId();
        return $db->lastInsertId();
    } catch (PDOException $e) {
        //echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        flash("<pre>" . var_export($e->errorInfo, true) . "</pre>");
        return -1;
    }
}




function update_data($table, $id,  $data, $ignore = ["id", "submit"])
{
    $columns = array_keys($data);
    foreach ($columns as $index => $value) {
        //Note: normally it's bad practice to remove array elements during iteration

        //remove id, we'll use this for the WHERE not for the SET
        //remove submit, it's likely not in your table
        if (in_array($value, $ignore)) {
            unset($columns[$index]);
        }
    }
    $query = "UPDATE $table SET "; //be sure you trust $table
    $cols = [];
    foreach ($columns as $index => $col) {
        array_push($cols, "$col = :$col");
    }
    $query .= join(",", $cols);
    $query .= " WHERE id = :id";

    $params = [":id" => $id];
    foreach ($columns as $col) {
        $params[":$col"] = se($data, $col, "", false);
    }
    $db = getDB();
    $stmt = $db->prepare($query);
    try {
        $stmt->execute($params);
        return true;
    } catch (PDOException $e) {
        flash("<pre>" . var_export($e->errorInfo, true) . "</pre>");
        return false;
    }
}


function sanitize_email($email = "")
{
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function is_valid_email($email = "")
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}


//New input
function sanitize_input($data)
{
    if (!is_null($data)) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
    }
    return $data;
}

function validate_password($password)
{
    if (strlen($password) < 8) {
        return false;
    }
    if (!preg_match("#[0-9]+#", $password)) {
        return false;
    }
    if (!preg_match("#[a-zA-Z]+#", $password)) {
        return false;
    }
    return true;
}


function validate_name($name)
{
    if (empty($name)) {
        flash("Name is required", "warning");
        return false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        flash("Only alphabets and white space are allowed");
        return false;
    }
    return true;
}


function validate_email($email)
{
    if (empty($email)) {
        flash("Email is required");
        return false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash("Invalid email format");
        return false;
    }
    return true;
}


function validate_message($message)
{
    if (empty($message)) {
        flash("Message is required");
        return false;
    } else if (!preg_match("/(?:\s*[a-zA-Z0-9]{2,}\s*)*/", $message)) {
        flash("Only alphabets and white space are allowed");
        return false;
    }
    return true;
}



function redirect($path)
{ //header headache
    //https://www.php.net/manual/en/function.headers-sent.php#90160
    /*headers are sent at the end of script execution otherwise they are sent when the buffer reaches it's limit and emptied */
    if (!headers_sent()) {
        //php redirect
        die(header("Location: " . get_url($path)));
    }
    //javascript redirect
    echo "<script>window.location.href='" . get_url($path) . "';</script>";
    //metadata redirect (runs if javascript is disabled)
    echo "<noscript><meta http-equiv=\"refresh\" content=\"0;url=" . get_url($path) . "\"/></noscript>";
    die();
}

<<<<<<< HEAD
// Function to display a flash message, given a session and message parameters
function flash(&$session, $msg = "", $color = "info") {
    // Creating a message array with text and color
    $message = ["text" => $msg, "color" => $color];

    // If flash session variable is not set, initialize it as an empty array
    if (!isset($session['flash'])) {
        $session['flash'] = [];
    }
    // Add the new message to the flash session variable
    array_push($session['flash'], $message);
}
=======

>>>>>>> b4c6d47 (new front end and backend page)





?>