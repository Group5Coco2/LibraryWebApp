<?php
if ($_GET['user'] !== "" && ($_GET['user'] == 'Students' || $_GET['user'] == 'Staffs')) {
    $con = new mysqli('mysql_db', 'root', 'root', 'uni_book_db');
    if (!$con) {
        echo "Fail";
        die("Connection failed: " .mysqli_connect_errno());
    }
    $user = $_GET["user"];
    $input_email = $_POST["input_email"];
    $input_password = $_POST["input_password"];
    $sql = "SELECT Username FROM $user WHERE Email='$input_email' AND Pass='$input_password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $cookie_name = "user";
        $cookie_value = $row["Username"];
        setcookie($cookie_name, $cookie_value, time() + (86400 * 1), "/"); // 86400 = 1 day
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php");
    }
    else {
        session_start();
        $_SESSION["wrongpassword"] = "wrong";
        header("Location: login.php?user=$user");
    }
    // closing connection
    mysqli_close($con);
}
else {
    header('Location: userCheck.php');
}
?>