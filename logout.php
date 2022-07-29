<?php

session_start();
session_unset();
session_destroy();
header("Location:log_or_sign.html");
exit();

?>