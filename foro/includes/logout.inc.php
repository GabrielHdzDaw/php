<?php
session_destroy();
unset($_SESSION['started']);
unset($_SESSION['session_token']);
unset($_SESSION['user_info']);


header("Location: ../index.php");
