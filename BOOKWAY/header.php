<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookWay - Каталог книг</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header-container">
        <div class="header-content">
            <a href="index.php" class="logo-link">
                <img src="logo.png" alt="BookWay" class="logo-img">
            </a>
            
            <div class="search-container">
    <form class="search-form" action="search.php" method="get">
        <input type="text" name="query" id="searchInput" class="search-input" 
               placeholder="Поиск по книгам и авторам..." 
               value="<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>" 
               autocomplete="off">
        <button type="submit" class="search-button">Найти</button>
    </form>
    <div class="search-results" id="searchResults"></div>
</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const searchContainer = document.querySelector('.search-container');
            
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }
                
                fetch(`search_suggest.php?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            searchResults.innerHTML = data.map(item => `
                                <div class="search-result-item" data-id="${item.book_id}">
                                    <img src="uploads/books/${item.photo || 'placeholder.jpg'}" 
                                         class="search-result-image" 
                                         alt="${item.book_name}">
                                    <div class="search-result-text">
                                        <div class="search-result-title">${item.book_name}</div>
                                        <div class="search-result-author">${item.autor}</div>
                                    </div>
                                </div>
                            `).join('');
                            
                            document.querySelectorAll('.search-result-item').forEach(item => {
                                item.addEventListener('click', function() {
                                    window.location.href = `book.php?id=${this.getAttribute('data-id')}`;
                                });
                            });
                            
                            searchResults.style.display = 'block';
                        } else {
                            searchResults.innerHTML = '<div class="search-result-item">Ничего не найдено</div>';
                            searchResults.style.display = 'block';
                        }
                    });
            });
            
            document.addEventListener('click', function(e) {
                if (!searchContainer.contains(e.target)) {
                    searchResults.style.display = 'none';
                }
            });
        });
    </script>