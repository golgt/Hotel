function updateReservationPrice() {
    const checkIn = new Date(document.getElementById('check-in').value);
    const checkOut = new Date(document.getElementById('check-out').value);
    const days = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
    const basePricePerDay = 100; // Tu nastav svoju reálnu cenu

    if (!isNaN(days) && days > 0) {
        const fullPrice = (basePricePerDay * days).toFixed(2);
        document.getElementById('reservation-price').textContent = fullPrice;
    } else {
        document.getElementById('reservation-price').textContent = '0.00';
    }
}

// Volaj pri zmene dátumov
document.getElementById('check-in').addEventListener('change', updateReservationPrice);
document.getElementById('check-out').addEventListener('change', updateReservationPrice);

    document.getElementById('proceed-to-payment').addEventListener('click', function () {
    document.getElementById('payment-modal').style.display = 'flex';
});

// Dynamické generovanie počtu osôb
document.getElementById('room-select').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const capacity = parseInt(selected.getAttribute('data-capacity'));
    const guestSelect = document.getElementById('guests');

    guestSelect.innerHTML = '';

    if (!isNaN(capacity)) {
        for (let i = 1; i <= capacity; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = `${i} ${i === 1 ? 'osoba' : 'osoby'}`;
            guestSelect.appendChild(option);
        }
    } else {
        const option = document.createElement('option');
        option.textContent = 'Kapacita nie je dostupná';
        guestSelect.appendChild(option);
    }
});

// Odoslanie formulára
document.getElementById('confirm-payment').addEventListener('click', function () {
    const roomId = document.getElementById('room-select').value;
    const checkIn = document.getElementById('check-in').value;
    const checkOut = document.getElementById('check-out').value;
    const guests = document.getElementById('guests').value;
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const email = document.getElementById('email').value;
    const paymentMethod = document.querySelector('input[name="payment"]:checked')?.value || 'reception';
    const rawPoints = parseInt(document.getElementById('points-slider')?.value || 0, 10);
    const pointsDiscount = rawPoints * 0.1;

    // Spočítame maximálnu povolenú zľavu (napr. 25 % z ceny)
    const selectedRoom = document.getElementById('room-select').options[document.getElementById('room-select').selectedIndex];
    const roomPrice = selectedRoom ? parseFloat(selectedRoom.getAttribute('data-price')) || 0 : 0;
    const checkInDate = new Date(document.getElementById('check-in').value);
    const checkOutDate = new Date(document.getElementById('check-out').value);
    const nights = (checkOutDate - checkInDate) / (1000 * 60 * 60 * 24);
    const fullPrice = roomPrice * nights;

    const maxDiscount = fullPrice * 0.25; // 25 % z ceny
    const finalDiscount = Math.min(pointsDiscount, maxDiscount);

    // Získame len toľko bodov, koľko treba na max zľavu
    const finalPointsUsed = Math.floor(finalDiscount / 0.1); // späť na body (1 bod = 0.10 €)

    const formData = new URLSearchParams();
    formData.append('room_id', roomId);
    formData.append('check_in', checkIn);
    formData.append('check_out', checkOut);
    formData.append('guests', guests);
    formData.append('name', name);
    formData.append('surname', surname);
    formData.append('email', email);
    formData.append('payment_method', paymentMethod);
    formData.append('discount_value', finalDiscount.toFixed(2));
    
        fetch('db/make_reservation.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('payment-modal').style.display = 'flex';
                document.getElementById('reservation-form').reset();
    
                // Zavoláme po úspešnej rezervácii
                showThankYouMessage();
            }
        })
        .catch(err => {
            console.error(err);
            alert('Chyba pri odosielaní rezervácie.');
        });
    });
    
document.getElementById('confirm-payment2').addEventListener('click', function () {
    const roomId = document.getElementById('room-select').value;
    const checkIn = document.getElementById('check-in').value;
    const checkOut = document.getElementById('check-out').value;
    const guests = document.getElementById('guests').value;
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const email = document.getElementById('email').value;
    const paymentMethod = document.querySelector('input[name="payment"]:checked')?.value || 'reception';
    const rawPoints = parseInt(document.getElementById('points-slider')?.value || 0, 10);
    const discountValue = rawPoints / 10; // Prevod bodov na €

    const formData = new URLSearchParams();
    formData.append('room_id', roomId);
    formData.append('check_in', checkIn);
    formData.append('check_out', checkOut);
    formData.append('guests', guests);
    formData.append('name', name);
    formData.append('surname', surname);
    formData.append('email', email);
    formData.append('payment_method', paymentMethod);
    formData.append('discount_value', discountValue);

        fetch('db/make_reservation.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('payment-modal').style.display = 'flex';
                document.getElementById('reservation-form').reset();
    
                // Zavoláme po úspešnej rezervácii
                showThankYouMessage();
            }
        })
        .catch(err => {
            console.error(err);
            alert('Chyba pri odosielaní rezervácie.');
        });
    });
    
// Vernostné body
const useAllPointsCheckbox = document.getElementById('use-all-points');
const pointsSlider = document.getElementById('points-slider');
const pointsSliderContainer = document.querySelector('.points-slider-container');
const pointsValueLabel = document.getElementById('points-value');
const discountValue = document.getElementById('discount-value');

const maxDiscountPercent = 25;

useAllPointsCheckbox?.addEventListener('change', () => {
    pointsSliderContainer.style.display = useAllPointsCheckbox.checked ? 'block' : 'none';
});

pointsSlider?.addEventListener('input', () => {
    const points = parseInt(pointsSlider.value, 10);
    const discount = (points * 0.1).toFixed(2);
    pointsValueLabel.textContent = `${points} bodov`;
    discountValue.textContent = `${discount} €`;

    updatePrice();
});

// Prepnúť spôsob platby
document.querySelectorAll('input[name="payment"]').forEach(input => {
    input.addEventListener('change', () => {
        const cardForm = document.getElementById('card-payment-form');
        const receptionConfirm = document.getElementById('reception-payment-confirm');

        if (input.value === 'card') {
            cardForm.style.display = 'block';
            receptionConfirm.style.display = 'none';
        } else {
            cardForm.style.display = 'none';
            receptionConfirm.style.display = 'block';
        }
    });
});

// Zatvoriť modal
document.getElementById('close-modal').addEventListener('click', () => {
    document.getElementById('payment-modal').style.display = 'none';
});

// Zobrazenie ďakovnej správy
function showThankYouMessage() {
    // Skryjeme všetky platobné možnosti
    document.getElementById('card-payment-form').style.display = 'none';
    document.getElementById('reception-payment-confirm').style.display = 'none';
    document.querySelector('.loyalty-points')?.style.setProperty('display', 'none');
    document.querySelector('.payment-options')?.style.setProperty('display', 'none');
    
    // Zobrazíme ďakovnú správu
    const thankYou = document.getElementById('thank-you-message');
    thankYou.style.display = 'block'; // alebo 'flex' ak máš flexbox
}

// Dokončiť poďakovanie
document.getElementById('finish-order-btn')?.addEventListener('click', function () {
    document.getElementById('payment-modal').style.display = 'none';

    // Reset modalu ak by chcel používateľ urobiť ďalšiu rezerváciu
    document.querySelector('.loyalty-points')?.style.setProperty('display', 'block');
    document.querySelector('.payment-options')?.style.setProperty('display', 'block');
    document.getElementById('thank-you-message').style.display = 'none';
});
// Funkcia na aktualizáciu ceny
function updatePrice() {
    const roomSelect = document.getElementById('room-select');
    const finalPriceElement = document.getElementById('final-price');
    const selectedRoom = roomSelect.options[roomSelect.selectedIndex];
    const roomPrice = selectedRoom ? parseFloat(selectedRoom.getAttribute('data-price')) || 0 : 0;

    const checkInDate = new Date(document.getElementById('check-in').value);
    const checkOutDate = new Date(document.getElementById('check-out').value);

    // Vypočítame počet nocí
    const timeDiff = checkOutDate - checkInDate;
    const nights = timeDiff > 0 ? timeDiff / (1000 * 60 * 60 * 24) : 0;

    // Získame body (ak slider existuje)
    const usePoints = document.getElementById('use-all-points')?.checked;
    const points = usePoints ? parseInt(document.getElementById('points-slider')?.value || '0', 10) : 0;
    const discount = points * 0.1; // Každý bod má hodnotu 0.1 €

    if (roomPrice > 0 && nights > 0) {
        let totalPrice = roomPrice * nights;

        // Aplikuj zľavu, max 25 % z celkovej ceny
        const maxDiscount = totalPrice * 0.25;
        const finalDiscount = Math.min(discount, maxDiscount);
        totalPrice -= finalDiscount;

        finalPriceElement.innerText = `Celková cena: €${totalPrice.toFixed(2)} (so zľavou €${finalDiscount.toFixed(2)})`;
    } else {
        finalPriceElement.innerText = '0.00 €';
    }
}

// Event listener na zmenu izby
document.getElementById('room-select').addEventListener('change', updatePrice);

// Event listener na zmenu počtu osôb
document.getElementById('guests').addEventListener('input', updatePrice);

// Inicializácia ceny pri načítaní stránky (prvý výber)
updatePrice();