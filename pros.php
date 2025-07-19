<?php
include('connection.php');

if (isset($_POST["createID"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
    $conpass = mysqli_real_escape_string($conn, $_POST["conpass"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $roleONsite = mysqli_real_escape_string($conn, $_POST["role"]);
    $sqlInsert = "INSERT INTO `User` (name, email, role_on_site, password) 
    values ('$name','$email','$roleONsite','$pass')";

    if ($pass == $conpass) {
        if (mysqli_query($conn, $sqlInsert)) {
            header("Location:first.php");
        } else {
            die("something went wrong");
        }
    } else {
        echo "password does not match <a href='./signup.php'>Try again!</a>";
    }
}

if (isset($_POST["save_name"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $id = mysqli_real_escape_string($conn, $_POST["user_id"]);

    $sql = "SELECT * FROM User where user_id = $id AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $sqlUpdate = "UPDATE User SET name = '$name' WHERE user_id = $id;";

        if (mysqli_query($conn, $sqlUpdate)) {
            header("Location:namereset.php?user_id=$id");
        } else {
            die("something went wrong");
        }
    } else {
        echo "Password Wrong! Try Again...";
    }
}


if (isset($_POST["post_draft"])) {
    $postContent = mysqli_real_escape_string($conn, $_POST["post_content"]);
    $postTitle = mysqli_real_escape_string($conn, $_POST["post_title"]);
    $id = mysqli_real_escape_string($conn, $_POST["user_id"]);
    $state = mysqli_real_escape_string($conn, $_POST["state"]);
    $likes = 0;
    $dislikes = 0;
    $sqlPost = "INSERT INTO `Post` (post_text, likes, dislikes, title, state, user_id) 
    values ('$postContent',$likes,$dislikes,'$postTitle','$state',$id)";
    $result = mysqli_query($conn, $sqlPost);

    if (mysqli_query($conn, $sqlPost)) {
        session_start();
        $_SESSION["post_draft"] = "post added successfully";
        header("Location:hompage.php");
    } else {
        die("something went wrong");
    }
}
