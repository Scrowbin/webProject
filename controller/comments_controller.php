<?php
    require('../db/commentPdo.php');
    if (!isset($_GET['commentsID'])){
        exit('Invalid comment section');
    }
    $commentSectionID = $_GET['commentsID'];



?>