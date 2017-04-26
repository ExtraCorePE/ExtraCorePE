<?php

/*
 *
 *    ______      _              _____               _____  ______ 
 *   |  ____|    | |            / ____|             |  __ \|  ____|
 *   | |__  __  _| |_ _ __ __ _| |     ___  _ __ ___| |__) | |__   
 *   |  __| \ \/ / __| '__/ _` | |    / _ \| '__/ _ \  ___/|  __|  
 *   | |____ >  <| |_| | | (_| | |___| (_) | | |  __/ |    | |____ 
 *   |______/_/\_\\__|_|  \__,_|\_____\___/|_|  \___|_|    |______|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * @author ExtraCorePE
 * @link http://www.github.com/ExtraCorePE/ExtraCorePE
 * 
 *
 */

namespace pocketmine\event\inventory;

use pocketmine\event\Cancellable;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\Player;

class InventoryClickEvent extends InventoryEvent implements Cancellable {

    public static $handlerList = null;

    /** @var Player */
    private $who;
    private $slot;

    /** @var Item */
    private $item;

    /**
     * @param Inventory $inventory
     * @param Player    $who
     * @param int       $slot
     * @param Item      $item
     */
    public function __construct(Inventory $inventory, Player $who, $slot, Item $item) {
        $this->who = $who;
        $this->slot = $slot;
        $this->item = $item;
        parent::__construct($inventory);
    }

    /**
     * @return Player
     */
    public function getPlayer() {
        return $this->who;
    }

    /**
     * @return int
     */
    public function getSlot() {
        return $this->slot;
    }

    /**
     * @return Item
     */
    public function getItem() {
        return $this->item;
    }

}
