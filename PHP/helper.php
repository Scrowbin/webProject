<?php
function renderPublicationStatus($status, $year) {
    switch ($status) {
        case "Ongoing":
            return "<span class=\"text-success\"><strong>● PUBLICATION: $year, ONGOING</strong></span>";
        case "Hiatus":
            return "<span class=\"text-warning\"><strong>● PUBLICATION: $year, Hiatus</strong></span>";
        case "Completed":
            return "<span class=\"text-primary\"><strong>● PUBLICATION: COMPLETED</strong></span>";
        default:
            return "";
    }
}
//
//Trả về dv thởi gian lớn nhất 
function timeAgo($datetime) {
    $now = new DateTime();
    $then = new DateTime($datetime);
    $diff = $now->diff($then);

    if ($diff->y > 0) {
        return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    } elseif ($diff->m > 0) {
        return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    } elseif ($diff->d > 0) {
        return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
    } elseif ($diff->h > 0) {
        return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    } elseif ($diff->i > 0) {
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    } else {
        return 'just now';
    }
}

    //Trả về value là int nếu là int hoặc float nếu là float
    // ex: 6.00 -> 6, 3.5 -> 3.5 
function truncateNumber($number){
    return ($number == floor($number)) ? intval($number) : $number;
}

?>