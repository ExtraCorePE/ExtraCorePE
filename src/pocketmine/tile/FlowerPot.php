<?php

/*
 *
 *  _____   _____   __   _   _   _____  __    __  _____
 * /  ___| | ____| |  \ | | | | /  ___/ \ \  / / /  ___/
 * | |     | |__   |   \| | | | | |___   \ \/ /  | |___
 * | |  _  |  __|  | |\   | | | \___  \   \  /   \___  \
 * | |_| | | |___  | | \  | | |  ___| |   / /     ___| |
 * \_____/ |_____| |_|  \_| |_| /_____/  /_/     /_____/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author iTX Technologies
 * @link https://itxtech.org
 *
 */

namespace pocketmine\tile;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;

class FlowerPot extends Spawnable{

	public function __construct(Level $level, CompoundTag $nbt){
		if(!isset($nbt->item) or !($nbt->item instanceof ShortTag)){
			$nbt->item = new ShortTag("item", 0);
		}
		if(!isset($nbt->mData)){
			$nbt->mData = new IntTag("mData", 0);
		}
		parent::__construct($level, $nbt);
	}

    public function canAddItem(Item $item): bool
    {
        if (!$this->isEmpty()) {
            return false;
        }
        switch ($item->getId()) {
            /** @noinspection PhpMissingBreakStatementInspection */
            case Item::TALL_GRASS:
                if ($item->getDamage() === 1) {
                    return false;
                }
            case Item::SAPLING:
            case Item::DEAD_BUSH:
            case Item::DANDELION:
            case Item::RED_FLOWER:
            case Item::BROWN_MUSHROOM:
            case Item::RED_MUSHROOM:
            case Item::CACTUS:
                return true;
            default:
                return false;
        }
    }

	public function getItem() : Item{
		return Item::get((int) ($this->namedtag["item"] ?? 0), (int) ($this->namedtag["mData"] ?? 0), 1);
	}

	public function setItem(Item $item){
		$this->namedtag["item"] = $item->getId();
		$this->namedtag["mData"] = $item->getDamage();
		$this->onChanged();
	}

    public function removeItem(){
        $this->setItem(Item::get(Item::AIR));
    }

	public function isEmpty(): bool{
        return $this->getItem()->getId() === Item::AIR;
 	}

	public function getSpawnCompound(): CompoundTag{
		return new CompoundTag("", [
			new StringTag("id", Tile::FLOWER_POT),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			$this->namedtag->item,
			$this->namedtag->mData
		]);
	}
}
