<!-- Modálne okno pre platbu -->
<div id="payment-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
    <div id="payment-modal-content" style="background-color: white; padding: 20px; border-radius: 8px; width: 400px;">
        <h3 id="payment-modal-title">Platba</h3>

        <!-- Verostné body a formulár -->
        <div class="loyalty-points" style="margin-top: 20px; border-top: 1px solid #ddd; padding-top: 15px;">
    <h5>Vernostné body</h5>
    <p>Aktuálny stav: <strong><?= $userPoints ?> bodov</strong> (hodnota: <?= number_format($userPoints * 0.1, 2) ?> €)</p>

    <?php if ($userPoints > 0): ?>
    <div class="points-options">
        <div class="points-option" style="margin-bottom: 10px;">
            <input type="checkbox" id="use-all-points">
            <label for="use-all-points">Použiť body na zľavu (max. 25% z celkovej sumy)</label>
        </div>
        <div class="points-slider-container" style="display: none; margin-top: 10px;">
            <input type="range" id="points-slider" min="0" max="<?= $userPoints ?>" value="0" style="width: 100%;">
            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                <span>0 bodov</span>
                <span id="points-value">0 bodov</span>
                <span><?= $userPoints ?> bodov</span>
            </div>
            <div style="margin-top: 10px;">
                <p>Zľava: <span id="discount-value">0.00</span> €</p>
            </div>
        </div>
    </div>
    <?php else: ?>
    <p>Nemáte dostatok bodov na zľavu.</p>
    <?php endif; ?>
</div>


        <!-- Možnosti platby -->
        <div class="payment-options" style="margin-top: 20px;">
            <div class="payment-option" style="margin-bottom: 15px;">
                <input type="radio" id="reception-payment" name="payment" value="reception" checked>
                <label for="reception-payment">Platba pri recepcii</label>
            </div>
            <div class="payment-option" style="margin-bottom: 15px;">
                <input type="radio" id="card-payment" name="payment" value="card">
                <label for="card-payment">Platba kartou online</label>
            </div>
        </div>

        <!-- Tlačidlo pre potvrdenie platby pri recepcii -->
        <div id="reception-payment-confirm" style="margin-top: 20px;">
            <button action="button" type="submit" id="confirm-payment" style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%;">Potvrdiť rezerváciu</button>
        </div>

        <!-- Formulár pre platbu kartou -->
        <div id="card-payment-form" style="display: none;">
            <h4>Platba kartou</h4>
            <div class="card-form" style="margin-top: 15px;">
                <div style="margin-bottom: 15px;">
                    <label for="card-number" style="display: block; margin-bottom: 5px;">Číslo karty:</label>
                    <input type="text" id="card-number" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="expiry-date" style="display: block; margin-bottom: 5px;">Dátum expirácie:</label>
                    <input type="month" id="expiry-date" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="cvv" style="display: block; margin-bottom: 5px;">CVV:</label>
                    <input type="text" id="cvv" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <button type="button" id="confirm-payment2" style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%; ">Zaplatiť</button>
                
            </div>
        </div>

        <!-- Poďakovanie po platbe -->
        <div id="thank-you-message" style="display: none;">
            <h4>Ďakujeme za Vašu objednávku!</h4>
            <p>Vaša objednávka bola úspešne spracovaná.</p>
            <button id="finish-order-btn" style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%;">Dokončiť</button>
        </div>

        <!-- Tlačidlo na zatvorenie okna -->
        <button id="close-modal" style="margin-top: 20px; background-color: #f44336; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%;">Zatvoriť</button>
    </div>
</div>
