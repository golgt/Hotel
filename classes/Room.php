<?php 
class Room{
    public $id, $name, $price, $size, $capacity, $bed, $services, $image;

    public function __construct($row){
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->size = $row['size'];
        $this->bed = $row['bed'];
        $this->services = $row['services'];
        $this->image = $row['image'];
    }
    public function render(){
        echo '
        <div class="col-lg-4 col-md-6">
            <div class="room-item">
                <img src="' . htmlspecialchars($this->image) . '" alt="">
                <div class="ri-text">
                    <h4>' . htmlspecialchars($this->name) . '</h4>
                    <h3>' . $this->price . '$<span>/Za noc</span></h3>
                    <table>
                        <tbody>
                            <tr><td class="r-o">Veľkosť:</td><td>' . $this->size . '</td></tr>
                            <tr><td class="r-o">Kapacita:</td><td>' . $this->capacity . '</td></tr>
                            <tr><td class="r-o">Postel:</td><td>' . $this->bed . '</td></tr>
                            <tr><td class="r-o">Služby:</td><td>' . $this->services . '</td></tr>
                        </tbody>
                    </table>
                    <a href="#" class="primary-btn">Detaily</a>
                </div>
            </div>
        </div>
        ';
    }
}
?>