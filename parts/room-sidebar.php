<?php 
$room = $sidebarRoom ?? null;
?>
<div class="room-booking">
    <h3>Vaša rezervácia</h3>
    <form action="#">
        <div class="check-date">
            <label for="date-in">Check In:</label>                                              <!--kalendar prichodu a odchodu--> 
            <input type="text" class="date-input" id="date-in">
            <i class="icon_calendar"></i>
        </div>
        <div class="check-date">
            <label for="date-out">Check Out:</label>
            <input type="text" class="date-input" id="date-out">
            <i class="icon_calendar"></i>
        </div>
        <div class="select-option">
            <label for="guest">Hostia:</label>
            <select id="guest" name="guest">
            <?php
            $capacityRaw = $room->capacity ?? '';
            $capacity = intval(preg_replace('/\D/', '', $capacityRaw));           //odstráni všetko okrem čísel čiže z Maximálne 5 osôob bude len 5

            if ($capacity > 0) {                                                                                        //Vyberanie počtu hostí podla kapacity apartmánu
                for ($i = 1; $i <= $capacity; $i++) {
                echo "<option value=\"$i\">$i " . ($i == 1 ? "osoba" : "osoby") . "</option>";
                }
            } else {
                echo "<option value=\"\">Kapacita nie je dostupná</option>";
            }
            ?>
            </select>
        </div>
        <button type="submit">Zistiť dostupnosť</button>
    </form>
</div>
