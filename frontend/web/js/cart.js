document.addEventListener('DOMContentLoaded', function() {
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

        if (points.length > 0) {
            map.setBounds(collection.getBounds(), {
                checkZoomRange: true
            });
        }

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
                            productCard.style.opacity = '0';
                            setTimeout(() => {
                                productCard.remove();

                                const remainingProducts = document.querySelectorAll('.product-card').length;

                                if (remainingProducts === 0) {
                                    window.location.href = '/cart/empty';
                                } else {
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


    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        const x = this.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        this.value = !x[2] ? x[1] : '+' + x[1] + ' (' + x[2] + (x[3] ? ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '') : '');
    });

});

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

                this.updateOrderSummary(data.order);
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


document.querySelectorAll('input[name="delivery_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const courierAddress = document.getElementById('courierAddress');
        const pickupSection = document.querySelector('.pickup-section');

        if (this.value === '2') { // Курьер
            courierAddress.style.display = 'block';
            pickupSection.style.display = 'none';
        } else { // Самовывоз
            courierAddress.style.display = 'none';
            pickupSection.style.display = 'block';
        }
    });
});

document.getElementById('submitOrder').addEventListener('click', function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitOrder');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner"></span> Оформление...';
    submitBtn.disabled = true;

    const formData = new FormData();
    const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked').value;
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

    formData.append('phone', document.getElementById('phone').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('comment', document.getElementById('comment').value);
    formData.append('delivery_id', deliveryMethod);
    formData.append('payment_method', paymentMethod);

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
function validateCourierFields() {
    const city = document.getElementById('city').value.trim();
    const street = document.getElementById('street').value.trim();
    const house = document.getElementById('house').value.trim();

    if (!city) {
        showNotification('error', 'Укажите город доставки');
        return false;
    }
    if (!street) {
        showNotification('error', 'Укажите улицу доставки');
        return false;
    }
    if (!house) {
        showNotification('error', 'Укажите номер дома');
        return false;
    }
    return true;
}

document.querySelectorAll('.js-pickup-point').forEach(item => {
    item.addEventListener('click', function(event) {
        // Проверяем, был ли клик именно по блоку, а не по вложенным элементам
        if (event.target !== this &&
            !event.target.matches('input[type="radio"]') &&
            !event.target.matches('label')) {
            return;
        }

        // Остальной код без изменений
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
});

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
                window.location.href = '/cart/success-order';
            } else {
                showNotification('error', data.message || 'Ошибка при выборе пункта');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Ошибка соединения с сервером');
        })
}