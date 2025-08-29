<?php
class Validator{
    public static function validateReservationData(array $data): array{
        $errors = [];

        // Kontrola či boli vyplnené všetky povinné polia
        $required = ['room_id', 'check_in', 'check_out', 'guests', 'name', 'surname', 'email'];
        foreach($required as $field){
            if(empty($data[$field])){
                $errors[] = "Chýba údaj: $field";
            }
        }

        // Validácia formátu emailu
        if(!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $errors[] = "Neplatná emailová adresa."; 
        }

        // Validácia počtu hostí
        if(!empty($data['guests'] && (int)$data['guests'] <= 0)){
            $errors[] = "Neplatný počet osôb"; 
        }

        // Validácia dátumov príchodu a odchodu
        if(!empty($data['check_in']) && !empty($data['check_out'])){
           $checkInDate = DateTime::createFromFormat('Y-m-d', $data['check_in']);
           $checkOutDate = DateTime::createFromFormat('Y-m-d', $data['check_out']);
           if(!$checkInDate || !$checkOutDate || $checkInDate >= $checkOutDate){
                $errors[] = "Dátum odchodu musí byť po dátume príchodu.";
           } 
        }
        return $errors;
    }
}
?>