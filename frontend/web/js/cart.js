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
            // Получаем order_product_id вместо product_id
            const orderProductId = this.dataset.orderProductId;
            const productCard = this.closest('.product-card');

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


    // Маска для телефона
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        const x = this.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        this.value = !x[2] ? x[1] : '+' + x[1] + ' (' + x[2] + (x[3] ? ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '') : '');
    });
});