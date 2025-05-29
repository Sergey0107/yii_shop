document.addEventListener('DOMContentLoaded', function() {
    let map;
    let placemarks = [];

    ymaps.ready(initMap);

    function initMap() {
        map = new ymaps.Map('pickupMap', {
            center: [57.77, 40.97],
            zoom: 10,
            controls: ['zoomControl']
        });

        // Загрузка начальных пунктов выдачи (если есть)
        const initialPoints = window.points || [];
        updateMap(initialPoints);
        updatePointsList(initialPoints);

        document.getElementById('city-select').addEventListener('change', function() {
            const cityCode = this.value;
            if (cityCode) {
                loadPointsForCity(cityCode);
            }
        });
    }

    // Функция загрузки пунктов выдачи для города
    function loadPointsForCity(cityCode) {
        fetch(`/cart/get-pickup-points?cityCode=${cityCode}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(points => {
                updateMap(points);
                updatePointsList(points);
            })
            .catch(error => {
                console.error('Ошибка при загрузке пунктов выдачи:', error);
                showNotification('error', 'Ошибка при загрузке пунктов выдачи');
            });
    }

    // Функция обновления карты
    function updateMap(points) {
        placemarks.forEach(placemark => {
            map.geoObjects.remove(placemark);
        });
        placemarks = [];

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

            map.geoObjects.add(placemark);
            placemarks.push(placemark);

            placemark.events.add('click', function() {
                document.querySelector(`#point-${point.id}`).checked = true;
            });
        });

        if (points.length > 0) {
            map.setBounds(map.geoObjects.getBounds(), {
                checkZoomRange: true
            });
        }
    }

    // Функция обновления списка пунктов
    function updatePointsList(points) {
        const container = document.querySelector('.points-list-container');
        container.innerHTML = '';

        points.forEach(point => {
            const div = document.createElement('div');
            div.className = 'point-item js-pickup-point';
            div.dataset.lat = point.lat;
            div.dataset.lng = point.lng;
            div.dataset.id = point.id;
            div.dataset.name = point.name;
            div.dataset.address = point.address;
            div.dataset.hours = point.hours;

            div.innerHTML = `
            <input type="radio" name="pickup_point" id="point-${point.id}" value="${point.id}">
            <label for="point-${point.id}">
                <strong>${point.name}</strong>
                <span>${point.address}</span>
                <small>${point.hours}</small>
            </label>
        `;

            container.appendChild(div);

            // Привязка обработчика клика для нового элемента
            div.addEventListener('click', function(event) {
                // Проверяем, был ли клик именно по блоку, а не по вложенным элементам
                if (event.target !== this &&
                    !event.target.matches('input[type="radio"]') &&
                    !event.target.matches('label')) {
                    return;
                }

                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;

                const pointData = {
                    id: this.dataset.id,
                    lat: this.dataset.lat,
                    lng: this.dataset.lng,
                    name: this.dataset.name,
                    address: this.dataset.address,
                    hours: this.dataset.hours,
                };

                sendPickupPointSelection(pointData);
            });

            // Обработчик выбора пункта (существующий код)
            const input = div.querySelector('input');
            input.addEventListener('change', function() {
                if (this.checked) {
                    map.setCenter([point.lat, point.lng], 15);
                }
            });
        });
    }

    // Обработчики для работы с корзиной
    document.querySelectorAll('.product-remove').forEach(button => {
        button.addEventListener('click', function() {
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

                                const remainingProducts = document.querySelectorAll('.product-card').length;

                                if (remainingProducts === 0) {
                                    window.location.href = '/cart/empty';
                                } else {
                                    updateOrderSummary(data.order);
                                }
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

    // Обработчик для кнопки оформления заказа
    document.getElementById('submitOrder').addEventListener('click', function() {
        const submitBtn = this;
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner"></span> Оформление...';
        submitBtn.disabled = true;

        const formData = new FormData();
        const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked').value;
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        // Получаем стоимость доставки
        const deliveryPriceElement = document.querySelector('.delivery-price');
        const deliveryCost = parseFloat(deliveryPriceElement.getAttribute('data-delivery-cost')) || 0;

        formData.append('phone', document.getElementById('phone').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('comment', document.getElementById('comment').value);
        formData.append('delivery_id', deliveryMethod);
        formData.append('payment_method', paymentMethod);
        formData.append('delivery_price', deliveryCost);

        if (deliveryMethod === '1') { // Самовывоз
            const pickupPoint = document.querySelector('input[name="pickup_point"]:checked');
            if (!pickupPoint) {
                showNotification('error', 'Выберите пункт выдачи');
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                return;
            }
            formData.append('pickup_point_id', pickupPoint.value);
        } else { // Курьер
            if (!validateCourierFields()) {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
                return;
            }
            formData.append('city', document.getElementById('city').value);
            formData.append('street', document.getElementById('street').value);
            formData.append('house', document.getElementById('house').value);
        }

        fetch('/cart/submit', {
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
                    window.location.href = '/cart/success-order';
                } else {
                    showNotification('error', data.message || 'Ошибка при оформлении заказа');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Ошибка соединения с сервером');
            })
            .finally(() => {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            });
    });

    // Валидация полей для курьерской доставки
    function validateCourierFields() {
        const city = document.getElementById('city').value;
        const street = document.getElementById('street').value;
        const house = document.getElementById('house').value;

        if (!city || !street || !house) {
            showNotification('error', 'Заполните все поля адреса');
            return false;
        }
        return true;
    }
    function sendPickupPointSelection(pointData) {
        const formData = new FormData();

        formData.append('pickup_point_id', pointData.id);
        formData.append('name', pointData.name);
        formData.append('address', pointData.address);
        formData.append('hours', pointData.hours);

        // Отправка на сервер
        fetch('/cart/get-delivery-cost', {
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
                    // Обновляем стоимость доставки в интерфейсе
                    updateDeliveryPrice(data.delivery_cost);

                    // Показываем уведомление об успешном выборе пункта
                    showNotification('success', 'Пункт выдачи выбран');
                } else {
                    showNotification('error', data.message || 'Ошибка при выборе пункта');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Ошибка соединения с сервером');
            });
    }

    function updateDeliveryPrice(deliveryCost) {
        const deliveryPriceElement = document.querySelector('.delivery-price');
        const totalPriceElement = document.querySelector('.summary-row.total span:last-child');

        const productsPrice = parsePrice(document.querySelector('.summary-row span:last-child').textContent);

        // Обновляем стоимость доставки
        if (deliveryCost > 0) {
            deliveryPriceElement.textContent = new Intl.NumberFormat('ru-RU', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(deliveryCost) + ' ₽';
        } else {
            deliveryPriceElement.textContent = 'Бесплатно';
        }

        // Обновляем общую стоимость
        const totalCost = productsPrice + deliveryCost;
        console.log(productsPrice);
        totalPriceElement.textContent = new Intl.NumberFormat('ru-RU', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(totalCost) + ' ₽';

        deliveryPriceElement.setAttribute('data-delivery-cost', deliveryCost);
    }

    function parsePrice(priceText) {

        const cleanText = priceText.replace(/[^\d,]/g, '');

        const numericText = cleanText.replace(',', '');

        return parseFloat(numericText);
    }

    document.querySelectorAll('input[name="delivery_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === '2') { // Курьерская доставка
                // Сбрасываем стоимость доставки и пересчитываем для курьера
                updateDeliveryPrice(0);
                document.getElementById('courierAddress').style.display = 'block';
                document.querySelector('.pickup-section').style.display = 'none';
            } else { // Самовывоз
                document.getElementById('courierAddress').style.display = 'none';
                document.querySelector('.pickup-section').style.display = 'block';
                // Если уже выбран пункт выдачи, пересчитываем стоимость
                const selectedPoint = document.querySelector('input[name="pickup_point"]:checked');
                if (selectedPoint) {
                    const pointElement = selectedPoint.closest('.js-pickup-point');
                    const pointData = {
                        id: pointElement.dataset.id,
                        lat: pointElement.dataset.lat,
                        lng: pointElement.dataset.lng,
                        name: pointElement.dataset.name,
                        address: pointElement.dataset.address,
                        hours: pointElement.dataset.hours,
                    };
                    sendPickupPointSelection(pointData);
                }
            }
        });
    });

    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `notification ${type} slide-up`;
        notification.innerHTML = `
        <div class="notification-content">
            <div class="notification-icon">
                ${type === 'success' ?
            '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' :
            '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'}
            </div>
            <div class="notification-text">${message}</div>
            <button class="notification-close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>
    `;


        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('slide-up');
        }, 10);

        notification.querySelector('.notification-close').addEventListener('click', () => {
            closeNotification(notification);
        });

        const autoCloseTimer = setTimeout(() => {
            closeNotification(notification);
        }, 5000);

        notification.addEventListener('mouseenter', () => {
            clearTimeout(autoCloseTimer);
        });

        notification.addEventListener('mouseleave', () => {
            setTimeout(() => {
                closeNotification(notification);
            }, 2000);
        });
    }

    function closeNotification(notification) {
        if (!notification) return;

        notification.classList.add('slide-down');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }

    function updateQuantity(orderProductId, action) {
        const url = `/cart/${action}?id=${orderProductId}`;
        const quantityElement = document.querySelector(`.quantity-btn[data-order-product-id="${orderProductId}"]`)
            .closest('.quantity-controls')
            .querySelector('.product-quantity');

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
                    quantityElement.textContent = data.quantity;

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
        console.log(orderData);
        if (!orderData) return;

        const totalItems = orderData.products_count || 0;
        const totalPrice = orderData.total_price || 0;

        updateCartBadge(totalItems);

        updateOrderSummaryElements(totalItems, totalPrice);
    }

    function updateCartBadge(count) {
        const badges = document.querySelectorAll('.position-absolute.badge.bg-danger.cart-counter');

        badges.forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? '' : 'none';

            badge.dataset.count = count;

            badge.classList.add('badge-pulse');
            setTimeout(() => badge.classList.remove('badge-pulse'), 0);
        });
    }

    function updateOrderSummaryElements(itemsCount, totalPrice) {
        if (typeof totalPrice !== 'number') {
            console.error('Invalid totalPrice:', totalPrice);
            return;
        }

        const formattedPrice = new Intl.NumberFormat('ru-RU').format(totalPrice);


        const itemsText = `Товары (${itemsCount})`;
        document.querySelectorAll('.summary-row:first-child span:first-child').forEach(el => {
            el.textContent = itemsText;
        });


        document.querySelectorAll('.summary-row:not(.total) span:last-child').forEach(el => {
            el.textContent = `${formattedPrice} ₽`;
        });


        document.querySelectorAll('.summary-row.total span:last-child').forEach(el => {
            el.textContent = `${formattedPrice} ₽`;
        });


        document.querySelectorAll('.summary-row.total').forEach(row => {
            row.classList.add('summary-updated');
            setTimeout(() => row.classList.remove('summary-updated'), 0);
        });
    }

    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const orderProductId = this.dataset.orderProductId;
            const isPlus = this.classList.contains('plus');
            const action = isPlus ? 'plus' : 'minus';

            updateQuantity(orderProductId, action);
        });
    });
})
















