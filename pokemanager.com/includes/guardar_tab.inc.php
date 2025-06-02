<?php
session_start();
if (isset($_GET['tab'])) {
    $_SESSION['tab'] = $_GET['tab'];
}