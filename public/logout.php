<?php

require_once '../src/setup.php';

session_destroy();
header('Location: index.php');
die;
