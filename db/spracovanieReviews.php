<?php 
require_once ('../classes/Review.php');
use reviews\Review;

// Získanie údajov z formulára
$roomId = (int)$_POST['room_id'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$rating = (int)$_POST['rating'];
$comment = trim($_POST['comment']);

// Validácia
if(empty($roomId) || empty($name) || empty($email) || empty($rating) || empty($comment)) {
    die('Chyba: Všetky polia sú povinné!');
}

$review = new Review();
$ulozene = $review->ulozitSpravu($roomId, $name, $email, $rating, $comment);

if ($ulozene) {
    // Presmerovanie naspäť na detail izby aj s úspešnou hláškou
    header("Location: ../room-details.php?id=$roomId&success=1");
    exit;
} else {
    header("Location: ../room-details.php?id=$roomId&error=1");
    exit;
}