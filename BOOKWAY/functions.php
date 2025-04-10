<?php
function sanitizeOutput($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function getBookCover($bookId, $default = 'placeholder.jpg') {
    $coverPath = "covers/{$bookId}.jpg";
    return file_exists($coverPath) ? $coverPath : $default;
}
?>