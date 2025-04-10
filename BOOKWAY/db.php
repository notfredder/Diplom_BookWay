<?php
function connectToDatabase() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'bookway';
    
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

function getAllBooks() {
    $conn = connectToDatabase();
    $result = $conn->query("SELECT * FROM book");
    
    if (!$result) {
        die("Ошибка запроса: " . $conn->error);
    }
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getNewBooks($limit = 10) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM book ORDER BY book_id DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getBookById($id) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM book WHERE book_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); // Используем fetch_assoc() вместо fetch()
}


function getRandomBooks($limit = 15) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM book ORDER BY RAND() LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getLatestBooks($limit = 10) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM book ORDER BY book_id DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getNewBooksByYear($limit = 10) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM book ORDER BY year DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getBooksByPublisher($publisher, $limit = 10) {
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM book WHERE publishing_house = ? ORDER BY year DESC LIMIT ?");
    $stmt->bind_param("si", $publisher, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>