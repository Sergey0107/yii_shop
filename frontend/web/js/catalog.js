// Функция для обновления счетчика корзины
function updateCartCounter(count) {
    const cartCounter = document.querySelector('.cart-counter');
    if (cartCounter) {
        cartCounter.textContent = count;
        cartCounter.style.display = count > 0 ? 'flex' : 'none';
    }
}

// Функция для показа уведомлений
function showNotification(message, type = 'success') {
    // Создаем элемент уведомления
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    // Добавляем в DOM
    document.body.appendChild(notification);

    // Автоматическое скрытие через 3 секунды
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Стили для уведомлений (можно добавить в CSS)
const style = document.createElement('style');
style.textContent = `
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            color: white;
            z-index: 1000;
            animation: slide-in 0.3s ease-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .success {
            background-color: #4CAF50;
        }
        .error {
            background-color: #F44336;
        }
        .fade-out {
            animation: fade-out 0.3s ease-in forwards;
        }
        @keyframes slide-in {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fade-out {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
document.head.appendChild(style);

function addToCart(productId) {
    // AJAX запрос для добавления в корзину
    $.post('/cart/add', {product_id: productId})
        .done(function(response) {
            if(response && response.success) {
                // Обновляем счетчик корзины
                if(response.cartCount !== undefined) {
                    updateCartCounter(response.cartCount);
                }
                showNotification('Товар добавлен в корзину');
            } else {
                const errorMsg = response && response.message ? response.message : 'Неизвестная ошибка';
                showNotification('Ошибка: ' + errorMsg, 'error');
            }
        })
        .fail(function(xhr) {
            let errorMsg = 'Ошибка сервера';
            if(xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            showNotification(errorMsg, 'error');
        });
}

