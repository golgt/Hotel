<?php
class Room {
    public $id, $name, $price, $size, $capacity, $bed, $services, $image,$description;

    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->size = $row['size'];
        $this->capacity = $row['capacity'];
        $this->bed = $row['bed'];
        $this->services = $row['services'];
        $this->image = $row['image'];
        $this->description = $row['description'];
    }

    public function render() {
        echo '
        <div class="col-lg-4 col-md-6">
            <div class="room-item">
                <img src="' . htmlspecialchars($this->image) . '" alt="' . htmlspecialchars($this->name) . '">
                <div class="ri-text">
                    <h4>' . htmlspecialchars($this->name) . '</h4>
                    <h3>' . $this->price . '€<span>/Za noc</span></h3>
                    <table>
                        <tbody>
                            <tr><td class="r-o">Veľkosť:</td><td>' . $this->size . '</td></tr>
                            <tr><td class="r-o">Kapacita:</td><td>' . $this->capacity . '</td></tr>
                            <tr><td class="r-o">Postel:</td><td>' . $this->bed . '</td></tr>
                            <tr><td class="r-o">Služby:</td><td>' . $this->services . '</td></tr>
                        </tbody>
                    </table>
                    <a href="./room-details.php?id=' . $this->id . '" class="primary-btn">Detail izby</a>
                </div>
            </div>
        </div>';
    }
    public function renderDetail()
{
    echo '
    <div class="room-details-item">
        <img src="' . htmlspecialchars($this->image) . '" alt="' . htmlspecialchars($this->name) . '">
        <div class="rd-text">
            <div class="rd-title">
                <h3>' . htmlspecialchars($this->name) . '</h3>
                <div class="rdt-right">
                    <div class="rating">
                        <i class="icon_star"></i>
                        <i class="icon_star"></i>
                        <i class="icon_star"></i>
                        <i class="icon_star"></i>
                        <i class="icon_star-half_alt"></i>
                    </div>
                    <a href="reservations.php">Zarezervovať</a>
                </div>
            </div>
            <h2>' . htmlspecialchars($this->price) . '€<span>/noc</span></h2>
            <table>
                <tbody>
                    <tr>
                        <td class="r-o">Veľkosť:</td>
                        <td>' . htmlspecialchars($this->size ?? 'N/A') . '</td>
                    </tr>
                    <tr>
                        <td class="r-o">Kapacita:</td>
                        <td>' . htmlspecialchars($this->capacity) . '</td>
                    </tr>
                    <tr>
                        <td class="r-o">Posteľ:</td>
                        <td>' . htmlspecialchars($this->bed ?? 'King Bed') . '</td>
                    </tr>
                    <tr>
                        <td class="r-o">Služby:</td>
                        <td>' . htmlspecialchars($this->services ?? 'Wifi, TV, kúpeľňa') . '</td>
                    </tr>
                </tbody>
            </table>
            <p class="f-para">' . nl2br(htmlspecialchars($this->description)) . '</p>
        </div>
    </div>
    ';
}

}
?>