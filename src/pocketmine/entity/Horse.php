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

namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\item\Item as ItemItem;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\protocol\MobArmorEquipmentPacket;

class Horse extends Living{

	const NETWORK_ID = 23;

	public function getName() : string{
		return "Horse";
	}

	public function setChestPlate($id){
		/*
		416, 417, 418, 419 only
		*/
		$pk = new MobArmorEquipmentPacket();
		$pk->eid = $this->getId();
		$pk->slots = [
		ItemItem::get(0,0),
		ItemItem::get($id,0),
		ItemItem::get(0,0),
		ItemItem::get(0,0)
		];
		foreach($this->level->getPlayers() as $player){
			$player->dataPacket($pk);
		}
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->eid = $this->getId();
		$pk->type = self::NETWORK_ID;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}

}
