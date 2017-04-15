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

namespace pocketmine\block;

use pocketmine\Player;
use pocketmine\item\Item;

class EndRod extends Flowable{

	protected $id = self::END_ROD;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 14;
	}

	public function getName() : string {
		return "End Rod";
	}

	public function getResistance(){
        return 0;
    }
	
	public function getHardness(){
        return 0;
    }

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
			$faces = [
				0 => 0,
				1 => 1,
				2 => 3,
				3 => 2,
				4 => 5,
				5 => 4,
			];
			$this->meta = ($target->getId() === self::END_ROD && $faces[$face] == $target->getDamage()) ? Vector3::getOppositeSide($faces[$face]) : $faces[$face];
			$this->getLevel()->setBlock($block, $this, true, true);
			return true;
		}

	public function getDrops(Item $item) : array {
		return [
			[$this->id, 0, 1],
		];
	}

}
