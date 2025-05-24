document.addEventListener('DOMContentLoaded', function() {
    // Инициализация карты
    ymaps.ready(initMap);

    function initMap() {
        const map = new ymaps.Map('pickupMap', {
            center: [57.77, 40.97], // Москва по умолчанию
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

    // Обработчик для кнопки удаления товара
    document.querySelectorAll('.product-remove').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productCard = this.closest('.product-card');
            if (confirm('Удалить товар из корзины?')) {
                fetch('/cart/delete?product_id=' + productId, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            productCard.style.opacity = '0';
                            setTimeout(() => {
                                productCard.remove();
                                updateOrderSummary(data.order);
                            }, 300);
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

    // Обработчик оформления заказа
    document.getElementById('submitOrder').addEventListener('click', function() {
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const comment = document.getElementById('comment').value;
        const pickupPoint = document.querySelector('input[name="pickup_point"]:checked')?.value;

        if (!phone || !email) {
            alert('Пожалуйста, заполните все обязательные поля');
            return;
        }

        if (!pickupPoint) {
            alert('Пожалуйста, выберите пункт выдачи');
            return;
        }

        const formData = new FormData();
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('comment', comment);
        formData.append('pickup_point', pickupPoint);

        fetch('/order/create', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/order/success?id=' + data.orderId;
                } else {
                    alert(data.message || 'Ошибка при оформлении заказа');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ошибка при оформлении заказа');
            });
    });

    // Маска для телефона
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        const x = this.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        this.value = !x[2] ? x[1] : '+' + x[1] + ' (' + x[2] + (x[3] ? ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '') : '');
    });

    // Обновление итоговой информации
    function updateOrderSummary(order) {
        document.querySelector('.summary-row.total span:last-child').textContent = order.total_price + ' ₽';
        document.querySelector('.summary-row:first-child span:last-child').textContent = order.total_price + ' ₽';
        document.querySelector('.summary-row:first-child span:first-child').textContent = 'Товары (' + order.products_count + ')';
    }
});