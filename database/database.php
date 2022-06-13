<?php

session_start();

$Website['name'] = 'School Management Systeem';
$Website['url'] = '';

$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'school_mms';

$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
