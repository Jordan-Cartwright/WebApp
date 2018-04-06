<?php

session_start();

session_destroy();

unset($_SESSION);

header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");

?>