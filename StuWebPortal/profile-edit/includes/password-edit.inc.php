<?php

if (isset($_POST['update-profile'])) {

    if (!empty($oldPassword) && !empty($newpassword) && !empty($passwordrepeat)) {

        $sql = "SELECT `password` FROM stu_users WHERE id=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
            echo "<script>window.location.href = '../'; </script>";
            // header("Location: ../");
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                $pwdCheck = password_verify($oldPassword, $row['password']);

                if ($pwdCheck == false) {

                    $_SESSION['ERRORS']['passworderror'] = 'incorrect current password';
                    echo "<script>window.location.href = '../'; </script>";
                    // header("Location: ../");
                    exit();
                }
                if ($oldPassword == $newpassword) {

                    $_SESSION['ERRORS']['passworderror'] = 'new password cannot be same as old password';
                    echo "<script>window.location.href = '../'; </script>";
                    // header("Location: ../");
                    exit();
                }
                if ($newpassword !== $passwordrepeat) {

                    $_SESSION['ERRORS']['passworderror'] = 'confirmed password does not match new password';
                    echo "<script>window.location.href = '../'; </script>";
                    // header("Location: ../");
                    exit();
                }

                $passwordUpdated = true;

                // script endpoint --------->>
            }
        }
    } else {

        $_SESSION['ERRORS']['passworderror'] = 'password fields cannot be empty for password updation';
        echo "<script>window.location.href = '../'; </script>";
        // header("Location: ../");
        exit();
    }
} else {

    echo "<script>window.location.href = '../'; </script>";
    // header("Location: ../");
    exit();
}
