document.addEventListener('DOMContentLoaded', function() {
    // Инициализация карты
    ymaps.ready(initMap);

    function initMap() {
        const map = new ymaps.Map('pickupMap', {
            center: [57.77, 40.97],
            zoom: 10
        });

        const points = JSON.parse(document.getElementById('pickupMap').dataset.points);
        const collection = new ymaps.GeoObjectCollection();

        points.forEach(point => {
            const placemark = new ymaps.Placemark(
                [point.lat, point.lng],
                {
                    balloonContent: `
                        <strong>${point.name}</strong><br>
                        ${point.address}<br>
                        Часы работы: ${point.hours}
                    `
                },
                {
                    preset: 'islands#blueDotIcon'
                }
            );

            collection.add(placemark);

            // Обработчик клика по пункту на карте
            placemark.events.add('click', function() {
                document.querySelector(`#point-${point.id}`).checked = true;
            });
        });

        map.geoObjects.add(collection);

        // Автоматическое масштабирование карты
        if (points.length > 0) {
            map.setBounds(collection.getBounds(), {
                checkZoomRange: true
            });
        }

        // Обработчик выбора пункта из списка
        document.querySelectorAll('.point-item input').forEach(input => {
            input.addEventListener('change', function() {
                if (this.checked) {
                    const point = points.find(p => p.id == this.value);
                    if (point) {
                        map.setCenter([point.lat, point.lng], 15);
                    }
                }
            });
        });
    }

    document.querySelectorAll('.product-remove').forEach(button => {
        button.addEventListener('click', function() {
            const orderProductId = this.dataset.orderProductId;
            const productCard = this.closest('.product-card');
            const productCards = document.querySelectorAll('.product-card'); // Все карточки товаров

            if (confirm('Удалить товар из корзины?')) {
                fetch('/cart/remove?order_product_id=' + orderProductId, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Анимация удаления карточки
                            productCard.style.opacity = '0';
                            setTimeout(() => {
                                productCard.remove();

                                // Проверяем остались ли еще товары
                                const remainingProducts = document.querySelectorAll('.product-card').length;

                                if (remainingProducts === 0) {
                                    // Если товаров не осталось - редирект
                                    window.location.href = '/cart/empty';
                                } else {
                                    // Если товары остались - обновляем итоги
                                    updateOrderSummary(data.order);
                                }
                            }, 1);
                        } else {
                            alert('Ошибка при удалении товара');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ошибка при удалении товара');
                    });
            }
        });
    });

    // Обработчик для кнопки очистки корзины
    document.getElementById('clearCart').addEventListener('click', function() {
        if (confirm('Очистить всю корзину?')) {
            fetch('/cart/clear', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Ошибка при очистке корзины');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка при очистке корзины');
                });
        }
    });


    // Маска для телефона
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        const x = this.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        this.value = !x[2] ? x[1] : '+' + x[1] + ' (' + x[2] + (x[3] ? ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '') : '');
    });

    function updateOrderSummary(orderData) {
        if (!orderData) return;

        const totalItems = orderData.products_count || 0;
        const totalPrice = orderData.total_price || 0;

        updateCartBadge(totalItems);

        updateOrderSummaryElements(totalItems, totalPrice);
    }

    function updateCartBadge(count) {
        const badges = document.querySelectorAll('.position-absolute.badge.bg-danger.cart-counter');

        badges.forEach(badge => {
            // Обновляем текст и видимость
            badge.textContent = count;
            badge.style.display = count > 0 ? '' : 'none';

            badge.dataset.count = count;

            badge.classList.add('badge-pulse');
            setTimeout(() => badge.classList.remove('badge-pulse'), 300);
        });
    }

    function updateOrderSummaryElements(itemsCount, totalPrice) {
        // Обновление количества товаров
        document.querySelectorAll('.summary-row:first-child span:first-child').forEach(el => {
            el.textContent = `Товары (${itemsCount})`;
        });

        // Обновление цены
        const formattedPrice = new Intl.NumberFormat('ru-RU').format(totalPrice);
        document.querySelectorAll('.summary-row span:last-child').forEach(el => {
            el.textContent = `${formattedPrice} ₽`;
        });

        document.querySelectorAll('.summary-row.total').forEach(row => {
            row.classList.add('summary-updated');
            setTimeout(() => row.classList.remove('summary-updated'), 1);
        });
    }

});

// Обработчики для кнопок +/-
document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', function() {
        const orderProductId = this.dataset.orderProductId;
        const isPlus = this.classList.contains('plus');
        const action = isPlus ? 'plus' : 'minus';

        updateQuantity(orderProductId, action);
    });
});

function updateQuantity(orderProductId, action) {
    const url = `/cart/${action}?id=${orderProductId}`;
    const quantityElement = document.querySelector(`.quantity-btn[data-order-product-id="${orderProductId}"]`)
        .closest('.quantity-controls')
        .querySelector('.product-quantity');

    // Блокируем кнопки на время запроса
    const buttons = document.querySelectorAll(`.quantity-btn[data-order-product-id="${orderProductId}"]`);
    buttons.forEach(btn => btn.disabled = true);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Обновляем количество
                quantityElement.textContent = data.quantity;

                // Обновляем общую сумму товара (исправленная версия)
                const productCard = quantityElement.closest('.product-card');
                if (productCard) {
                    const priceText = productCard.querySelector('.product-price').textContent;
                    const price = parseFloat(productCard.querySelector('.product-price').dataset.price);

                    productCard.querySelector('.product-total').textContent =
                        (price * data.quantity).toLocaleString('ru-RU', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        }) + ' ₽';
                }

                // Обновляем сводку
                updateOrderSummary(data.order);
            } else {
                alert(data.message || 'Ошибка при изменении количества');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ошибка соединения');
        })
        .finally(() => {
            buttons.forEach(btn => btn.disabled = false);
        });
}

function updateOrderSummary(orderData) {
    if (!orderData) return;

    const totalItems = orderData.products_count || 0;
    const totalPrice = orderData.total_price || 0;

    updateCartBadge(totalItems);

    updateOrderSummaryElements(totalItems, totalPrice);
}

function updateCartBadge(count) {
    const badges = document.querySelectorAll('.position-absolute.badge.bg-danger.cart-counter');

    badges.forEach(badge => {
        // Обновляем текст и видимость
        badge.textContent = count;
        badge.style.display = count > 0 ? '' : 'none';

        badge.dataset.count = count;

        badge.classList.add('badge-pulse');
        setTimeout(() => badge.classList.remove('badge-pulse'), 300);
    });
}

function updateOrderSummaryElements(itemsCount, totalPrice) {
    // Обновление количества товаров
    document.querySelectorAll('.summary-row:first-child span:first-child').forEach(el => {
        el.textContent = `Товары (${itemsCount})`;
    });

    // Обновление цены
    const formattedPrice = new Intl.NumberFormat('ru-RU').format(totalPrice);
    document.querySelectorAll('.summary-row span:last-child').forEach(el => {
        el.textContent = `${formattedPrice} ₽`;
    });

    document.querySelectorAll('.summary-row.total').forEach(row => {
        row.classList.add('summary-updated');
        setTimeout(() => row.classList.remove('summary-updated'), 1);
    });
}