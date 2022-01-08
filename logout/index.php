<?php
include_once "../addons/extensions/bootstrap.php";
@session_destroy();

header("Location: ".BASE_URL);