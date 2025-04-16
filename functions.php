<?php 
function nactiajMenu($jsonFile){
    $jsonData = file_get_contents($jsonFile);
    $data = json_decode($jsonData,true);

    if(!isset($data['menu'])){                                                            // overuje ci existuje 'menu v JSON'
        return "<p>Chyba: Menu sa nenašlo v JSON súbore</p>";
    }

    $menuData = $data['menu'];                                                           // získa iba cast 'menu'
    $menuHTML = '<ul class="mainmenu">';

    foreach($menuData as $item) {
        $menuHTML .= '<li>';
        $menuHTML .= '<a href="' . htmlspecialchars($item["url"]) . '">' . htmlspecialchars($item["name"]) . '</a>';

        if(!empty($item["submenu"])){
            $menuHTML .= '<ul class="dropdown">';
            foreach($item["submenu"] as $subItem) {
                $menuHTML .= '<li><a href="' . htmlspecialchars($subItem["url"]) . '">' . htmlspecialchars($subItem["name"]) . '</a></li>';
            }
            $menuHTML .= '</ul>';
        }
        $menuHTML .= '</li>';
    }
    $menuHTML .= '</ul>';
    return $menuHTML;
}
?>