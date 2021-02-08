<?php
session_start(); //to access session variables
unset($_SESSION['name']);
unset($_SESSION['user_id']);
header('Location: index.php');
