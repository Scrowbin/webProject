<?php
    require_once('pdo.php');
    
    function getComments($commentSectionID,$limit,$offset){
        $sql = 'SELECT * FROM commentsection WHERE  = ? ORDER BY CreatedAt DESC LIMIT ? OFFSET ?';
        $comments = pdo_query($sql,$commentSectionID, $limit, $offset);
        
        
    }


?>