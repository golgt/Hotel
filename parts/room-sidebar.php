<?php 
$room = $sidebarRoom ?? null;
?>
<div class="room-booking">
    <h3>Vaša rezervácia</h3>
    <form id="availability-form">
        <div class="check-date">
            <label for="date-in">Check In:</label>                                       <!--kalendar prichodu a odchodu--> 
            <input type="date"  id="date-in" required>
            
        </div>
        <div class="check-date">
            <label for="date-out">Check Out:</label>
            <input type="date"  id="date-out" required>
            
        </div>
        <div class="select-option">
            <label for="guest">Hostia:</label>
            <select id="guest" name="guest">
            <?php
            $capacityRaw = $room->capacity ?? '';
            $capacity = intval(preg_replace('/\D/', '', $capacityRaw));                  //odstráni všetko okrem čísel čiže z Maximálne 5 osôob bude len 5

            if ($capacity > 0) {
                for ($i = 1; $i <= $capacity; $i++) {
                    echo "<option value=\"$i\">$i " . ($i == 1 ? "osoba" : "osoby") . "</option>";                                 //Vyberanie počtu hostí podla kapacity apartmánu
                }
            } else {
                echo "<option value=\"\">Kapacita nie je dostupná</option>";
            }
            ?>
            </select>
        </div>

        <!-- skrytý input s room_id -->
        <input type="hidden" id="room-id" value="<?= htmlspecialchars($room->id ?? '') ?>">

        <button type="submit">Zistiť dostupnosť</button>
    </form>
</div>

<div id="availability-result" style="margin-top: 10px;"></div>

<script>
document.querySelector('#availability-form').addEventListener('submit', function(e){                                       //JS ktorý vypíše ci je dosupná izba alebo nie v pripade chyby vypíše chybovú hlášku
    e.preventDefault();

    const checkIn = document.getElementById('date-in').value;
    const checkOut = document.getElementById('date-out').value;
    const roomId = document.getElementById('room-id').value;

    if (!roomId || !checkIn || !checkOut) {
        alert("Prosím, vyplňte všetky polia.");
        return;
    }

    fetch('db/check_availability.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `room_id=${roomId}&check_in=${checkIn}&check_out=${checkOut}`
    })
    .then(res => res.json())
    .then(data => {
        const resultDiv = document.getElementById('availability-result');
        resultDiv.innerHTML = data.message;
        resultDiv.style.color = data.available ? 'green' : 'red';
    })
    .catch(err => {
        console.error(err);
        alert('Nastala chyba pri overovaní dostupnosti.');
    });
});
</script>
