<?php
session_start();
include 'connection.php';

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $msg = $_POST['message'];

    // Sanitize user inputs
    $sanitized_email = mysqli_real_escape_string($connection, $email);
    $sanitized_name = mysqli_real_escape_string($connection, $name);
    $sanitized_msg = mysqli_real_escape_string($connection, $msg);

    // Insert data into database
    $query = "INSERT INTO user_feedback(name, email, message) VALUES('$sanitized_name', '$sanitized_email', '$sanitized_msg')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        // Redirect with success status
        header("Location: contact.html?status=success");
        exit();
    } else {
        echo '<script type="text/javascript">alert("Data not saved")</script>'; 
    }
}
?>
