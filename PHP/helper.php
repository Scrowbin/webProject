<?php
//
//xử lý tên artist/author sao cho nếu nó trùng chỉ trả về 1
//
function combineAuthorsAndArtists($authorsRaw, $artistsRaw) {
    // Get the names of authors and artists
    $authors = array_column($authorsRaw, 'AuthorName');
    $artists = array_column($artistsRaw, 'ArtistName');
    
    // Find common names (those that are both in authors and artists)
    $common = array_intersect($authors, $artists);
    
    // Remove common names from both authors and artists arrays
    $uniqueAuthors = array_diff($authors, $common);
    $uniqueArtists = array_diff($artists, $common);
    
    // Combine the unique authors, common names (added only once), and unique artists
    $combined = array_merge($uniqueAuthors, $common, $uniqueArtists);
    
    // Return the combined list as a string
    return implode(', ', $combined);
}

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
    $timezone = new DateTimeZone('Asia/Ho_Chi_Minh'); // or your actual timezone
$now = new DateTime('now', $timezone);
$ago = new DateTime($datetime, $timezone);
    // $now = new DateTime;
    // $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->y > 0) {
        return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    }

    if ($diff->m > 0) {
        return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    }

    if ($diff->d > 0) {
        return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
    }

    if ($diff->h > 0) {
        return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    }

    if ($diff->i > 0) {
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    }
    return 'just now';
}


function getFlag($language) {
    switch ($language) {
        case "en":
            return '<img class="flag" src="https://mangadex.org/img/flags/gb.svg">'; // English - Great Britain
        case "jp":
            return '<img class="flag" src="https://mangadex.org/img/flags/jp.svg">'; // Japanese - Japan
        case "kr":
            return '<img class="flag" src="https://mangadex.org/img/flags/kr.svg">'; // Japanese - Japan
        case "vn":
            return '<img class="flag" src="https://mangadex.org/img/flags/vn.svg">'; // Vietnamese - Vietnam
        case "English":
            return '<img class="flag" src="https://mangadex.org/img/flags/gb.svg">'; // English - Great Britain
        case "Japanese":
            return '<img class="flag" src="https://mangadex.org/img/flags/jp.svg">'; // Japanese - Japan
        case "Korean":
            return '<img class="flag" src="https://mangadex.org/img/flags/kr.svg">'; // Japanese - Japan
        case "Vietnamese":
            return '<img class="flag" src="https://mangadex.org/img/flags/vn.svg">'; // Vietnamese - Vietnam
        default:
            return '<img class="flag" src="https://mangadex.org/img/flags/gb.svg">'; // Default to GB flag
    }
}
function getFlagHome($language) {
    switch ($language) {
        case "en":
            return '<img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="GB">'; // English - Great Britain
        case "jp":
            return '<img src="https://mangadex.org/img/flags/jp.svg" class="flag-icon" alt="JP">'; // English - Great Britain
        case "kr":
            return '<img src="https://mangadex.org/img/flags/kr.svg" class="flag-icon" alt="KR">'; // English - Great Britain
        case "vn":
            return '<img src="https://mangadex.org/img/flags/vn.svg" class="flag-icon" alt="VN">'; // English - Great Britain
        case "English":
            return '<img class="flag-icon" src="https://mangadex.org/img/flags/gb.svg">'; // English - Great Britain
        case "Japanese":
            return '<img class="flag-icon" src="https://mangadex.org/img/flags/jp.svg">'; // Japanese - Japan
        case "Korean":
            return '<img class="flag-icon" src="https://mangadex.org/img/flags/kr.svg">'; // Japanese - Japan
        case "Vietnamese":
            return '<img src="https://mangadex.org/img/flags/vn.svg" class="flag-icon" alt="VN">'; // English - Great Britain
        default:
            return '<img src="https://mangadex.org/img/flags/gb.svg" class="flag-icon" alt="EN">'; // English - Great Britain
    }
}
function getFlagFeature($language) {
    switch ($language) {
        case "en":
            return '<img src="https://mangadex.org/img/flags/gb.svg" class="flag flag-featured" alt="GB">'; // English - Great Britain
        case "jp":
            return '<img src="https://mangadex.org/img/flags/jp.svg" class="flag flag-featured" alt="JP">'; // English - Great Britain
        case "kr":
            return '<img src="https://mangadex.org/img/flags/kr.svg" class="flag flag-featured" alt="KR">'; // English - Great Britain
        case "vn":
            return '<img src="https://mangadex.org/img/flags/vn.svg" class="flag flag-featured" alt="VN">'; // English - Great Britain
        case "English":
            return '<img class="flag flag-featured" src="https://mangadex.org/img/flags/gb.svg">'; // English - Great Britain
        case "Japanese":
            return '<img class="flag flag-featured" src="https://mangadex.org/img/flags/jp.svg">'; // Japanese - Japan
        case "Korean":
            return '<img class="flag flag-featured" src="https://mangadex.org/img/flags/kr.svg">'; // Japanese - Japan
        case "Vietnamese":
            return '<img src="https://mangadex.org/img/flags/vn.svg" class="flag flag-featured" alt="VN">'; // English - Great Britain
        default:
            return '<img src="https://mangadex.org/img/flags/gb.svg" class="flag flag-featured" alt="EN">'; // English - Great Britain
    }
}
    //Trả về value là int nếu là int hoặc float nếu là float
    // ex: 6.00 -> 6, 3.5 -> 3.5 
function truncateNumber($number){
    return ($number == floor($number)) ? intval($number) : $number;
}
function displayNameOrChapter($name,$number){
    if ($name === '' || $name === null){
        return "<div class='chapter'>Chapter $number</div>";
    }
    else return "<div class='chapter'>$name</div>";
}
function renderPagination($currentPage, $totalPages, $baseUrl = '?page=') {
    echo '<ul class="pagination">';

    // Previous button
    if ($currentPage > 1) {
        echo '<li class="page-item">
                <a class="page-link" href="' . $baseUrl . ($currentPage - 1) . '">&laquo;</a>
              </li>';
    }

    // Always show page 1
    echo '<li class="page-item ' . ($currentPage == 1 ? 'active orange' : '') . '">
            <a class="page-link" href="' . $baseUrl . '1">1</a>
          </li>';

    // Dots after 1
    if ($currentPage > 4) {
        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }

    // Pages around current
    for ($i = max(2, $currentPage - 1); $i <= min($totalPages - 1, $currentPage + 1); $i++) {
        echo '<li class="page-item ' . ($currentPage == $i ? 'active orange' : '') . '">
                <a class="page-link" href="' . $baseUrl . $i . '">' . $i . '</a>
              </li>';
    }

    // Dots before last
    if ($currentPage < $totalPages - 3) {
        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }

    // Last page
    if ($totalPages > 1) {
        echo '<li class="page-item ' . ($currentPage == $totalPages ? 'active orange' : '') . '">
                <a class="page-link" href="' . $baseUrl . $totalPages . '">' . $totalPages . '</a>
              </li>';
    }

    // Next button
    if ($currentPage < $totalPages) {
        echo '<li class="page-item">
                <a class="page-link" href="' . $baseUrl . ($currentPage + 1) . '">&raquo;</a>
              </li>';
    }

    echo '</ul>';
}
?>