<?php

class ServiceManager {
    private $services = [];

    public function __construct() {         // Konštruktor pre nastavenie jednotlivých služieb
        $this->services[] = new Service("flaticon-036-parking", "Plán cestovania", "Ponúkneme Vám jedinečné návrhy na výlety či v blízkom oklolí alebo aj v zahraničí.");
        $this->services[] = new Service("flaticon-033-dinner", "Catering Service", "Potrebujete miestnosť na oslavu? U nás nájdete tie najlepšie vybavené miestnosti spolu s službou v cene.");
        $this->services[] = new Service("flaticon-026-bed", "Babysitting", "Ak si chcete vychutnať príjemný večer spolu a nemáte kam dať dieťa? Nebojte sa a zvyšok nechajte na nás.");
        $this->services[] = new Service("flaticon-024-towel", "Práčovňa", "Potrebujete niečo rýchlo vyprať? Odovzdajte nám to na recepcií a do pár hodín budete mať u Vás na izbe čisté oblečenie.");
        $this->services[] = new Service("flaticon-044-clock-1", "Súkromný šofér", "Súkromný šofér v našom hoteli je jedna z najlepších služieb čo ponúkame. Stačí zavolať a máte vlastného šoféra s luxusným autom.");
        $this->services[] = new Service("flaticon-012-cocktail", "Bar & Drink", "Máme jeden z najlepšie vybavených barov v širokom oklolí. Naši kvalitný barmani Vám urobia akýkoľvek drink ktorý si budete želať.");
    }

    public function getServices() {      // Getter pre služby
        return $this->services;
    }

    public function renderServices() {                         // Funkcia pre vypísanie služieb
        $services = $this->getServices();
        foreach ($services as $service) {
            echo '<div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="'.$service->getIcon().'"></i>
                    <h4>'.$service->getTitle().'</h4>
                    <p>'.$service->getDescription().'</p>
                </div>
            </div>';
        }
    }
}

?>