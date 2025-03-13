<?php

include 'compute.php';
$function = $_POST['function'];

if ($function == "loginUser") {
    $names = $_POST["names"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM `users` WHERE `names`='$names' AND `password`='$password'";
    compute::instance()->fetch($sql,false);

}

if ($function == "addUser") {
    $names = $_POST["names"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $password = $_POST["password"];

    $sql = "INSERT INTO flockr.users(`names`, `email`, `phoneNumber`, `password`) 
                              VALUES ('$names','$email','$phoneNumber','$password')";

    compute::instance()->execute($sql);
}

if ($function == "getUsers"){
    $sql = "SELECT * FROM `users` ";
    compute::instance()->fetch($sql);
}

if ($function == "deleteUser") {
    $email = $_POST["email"];

    $sql = "DELETE FROM `users` WHERE `email`='$email'";
    compute::instance()->execute($sql);
}

if ($function == "editUser") {

    echo "I'm editing user";
}

if ($function == "updateUser") {
    $names = $_POST["names"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $password = $_POST["password"];

    $sql = "UPDATE `users` SET `names`='$names',`phoneNumber`='$phoneNumber',`email`='$email',`password`='$password'  WHERE `email`='$email'";
    compute::instance()->execute($sql);
}
