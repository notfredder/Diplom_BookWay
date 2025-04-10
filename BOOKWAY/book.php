<?php
require_once 'db.php';

$bookId = $_GET['id'] ?? 0;
$book = getBookById($bookId);

require_once 'header.php';

if (!$book) {
    echo '<div class="book-not-found"><p>Книга не найдена</p></div>';
    require_once 'footer.php';
    exit;
}

$imageFile = htmlspecialchars(trim($book['photo']));
$imagePath = 'uploads/books/' . $imageFile;
$imageUrl = file_exists(__DIR__ . '/' . $imagePath) ? $imagePath : 'placeholder.jpg';
?>

<div class="book-detail-page">
    <div class="book-content-wrapper">
        <!-- Большая картинка слева -->
        <div class="book-cover-container">
            <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($book['book_name']) ?>" class="book-cover-large">
        </div>
        
        <!-- Блок с названием, автором, кнопками и описанием -->
        <div class="book-info-right">
            <div class="book-header">
                <h1><?= htmlspecialchars($book['book_name']) ?></h1>
                <p class="book-author">
                    <a href="search.php?query=<?= urlencode($book['autor']) ?>" class="author-link">
                        <?= htmlspecialchars($book['autor']) ?>
                    </a>
                </p>
            </div>
            
            <div class="book-actions">
                <?php if (!empty($book['yabooks'])): ?>
                <a href="<?= htmlspecialchars($book['yabooks']) ?>" class="action-btn" target="_blank">
                    <img src="../uploads/YAKNIGI.jpg" alt="Читать на Я.Книги">
                </a>
                <?php endif; ?>
                
                <?php if (!empty($book['ozon'])): ?>
                <a href="<?= htmlspecialchars($book['ozon']) ?>" class="action-btn" target="_blank">
                    <img src="../uploads/OZON.jpg" alt="Купить на OZON">
                </a>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($book['about'])): ?>
            <div class="book-description">
                <div class="description-text" data-max-lines="13">
                    <?= nl2br(htmlspecialchars($book['about'])) ?>
                </div>
                <button class="show-more-btn">ещё</button>
            </div>
            <?php endif; ?>
        </div>
    </div> <!-- Закрываем book-content-wrapper -->
    
    <!-- Метаданные теперь ВНЕ обертки flex-контейнера -->
    <div class="book-meta-grid">
        <?php if (!empty($book['age'])): ?>
        <div class="meta-item">
            <span class="meta-label">Возрастные ограничения:</span>
            <span class="meta-value"><?= htmlspecialchars($book['age']) ?></span>
        </div>
        <?php endif; ?>
        <?php if (!empty($book['copyright_holder'])): ?>
        <div class="meta-item">
            <span class="meta-label">Правообладатель:</span>
            <span class="meta-value"><?= htmlspecialchars($book['copyright_holder']) ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($book['year'])): ?>
        <div class="meta-item">
            <span class="meta-label">Год выхода издания:</span>
            <span class="meta-value"><?= htmlspecialchars($book['year']) ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($book['publishing_house'])): ?>
        <div class="meta-item">
            <span class="meta-label">Издательство:</span>
            <span class="meta-value"><?= htmlspecialchars($book['publishing_house']) ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($book['translator'])): ?>
        <div class="meta-item">
            <span class="meta-label">Переводчик:</span>
            <span class="meta-value"><?= htmlspecialchars($book['translator']) ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($book['pages'])): ?>
        <div class="meta-item">
            <span class="meta-label">Бумажных страниц:</span>
            <span class="meta-value"><?= htmlspecialchars($book['pages']) ?></span>
        </div>
        <?php endif; ?>
    </div>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const descriptionTexts = document.querySelectorAll('.description-text');
    
    descriptionTexts.forEach(textBlock => {
        const lineHeight = parseInt(getComputedStyle(textBlock).lineHeight);
        const maxHeight = lineHeight * 13; // 13 строк
        
        // Проверяем, превышает ли текст максимальную высоту
        if (textBlock.scrollHeight > maxHeight) {
            const button = textBlock.nextElementSibling;
            button.style.display = 'block'; // Показываем кнопку "ещё"
            
            button.addEventListener('click', () => {
                textBlock.classList.toggle('expanded');
                button.textContent = textBlock.classList.contains('expanded') ? 'свернуть' : 'ещё';
            });
        }
    });
});
</script>

<?php
require_once 'footer.php';
?>