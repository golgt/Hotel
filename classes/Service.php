<?php
class Service {
    private $icon;
    private $title;
    private $description;

    public function __construct($icon, $title, $description) {                // Konštruktor pre inicializáciu atribútov
        $this->icon = $icon;
        $this->title = $title;
        $this->description = $description;
    }

   public function getIcon(){                         // Getter pre atribut icon
    return $this->icon;
   }
                                                         
   public function getTitle(){                          // Getter pre atribut title
    return $this->title;
   }

   public function getDescription(){                      // Getter pre atribut description
    return $this->description;
   }
   
   
        
}

?>