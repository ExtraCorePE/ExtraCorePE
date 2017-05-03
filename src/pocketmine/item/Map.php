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

namespace pocketmine\item;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\network\protocol\ClientboundMapItemDataPacket;
use pocketmine\utils\Color;

class Map{

	public $id;
	public $colors = [];
	public $scale;
	public $width;
	public $height;
	public $decorations = [];
	public $xOffset;
	public $yOffset;

	public function __construct(int $id = -1, array $colors = [], int $scale = 1, int $width = 128, int $height = 128, $decorations = [], int $xOffset = 0, int $yOffset = 0) {
		$this->id = $id;
		$this->colors = $colors;
		$this->scale = $scale;
		$this->width = $width;
		$this->height = $height;
		$this->decorations = $decorations;
		$this->xOffset = $xOffset;
		$this->yOffset = $yOffset;
	}

	public function setMapId(int $id){
		$this->id = $id;
	}

	public function getMapId(){
		return $this->id;
	}

	public function setColors(array $colors) {
		$this->colors = $colors;
		$this->update(ClientboundMapItemDataPacket::BITFLAG_TEXTURE_UPDATE);
	}

	public function getColors(){
		return $this->colors;
	}

	public function setScale(int $scale){
		$this->scale = $scale;
		$this->update(ClientboundMapItemDataPacket::BITFLAG_TEXTURE_UPDATE);
	}

	public function getScale(){
		return $this->scale;
	}

	public function setWidth(int $width){
		$this->width = $width;
		$this->update(ClientboundMapItemDataPacket::BITFLAG_TEXTURE_UPDATE);
	}

	public function getWidth(){
		return $this->width;
	}

	public function setHeight(int $height){
		$this->height = $height;
		$this->update(ClientboundMapItemDataPacket::BITFLAG_TEXTURE_UPDATE);
	}

	public function getHeight(){
		return $this->height;
	}

	public function addDecoration($decorations){
		$this->decorations[] = $decorations;
		end($this->decorations);
		$this->update(ClientboundMapItemDataPacket::BITFLAG_DECORATION_UPDATE);
		return key($this->decorations);
	}

	public function removeDecoration(int $id){
		unset($this->decorations[$id]);
		$this->update(ClientboundMapItemDataPacket::BITFLAG_DECORATION_UPDATE);
	}

	public function getDecorations(){
		return $this->decorations;
	}

	public function setXOffset(int $xOffset){
		$this->xOffset = $xOffset;
		$this->update(ClientboundMapItemDataPacket::BITFLAG_TEXTURE_UPDATE);
	}

	public function getXOffset(){
		return $this->xOffset;
	}

	public function setYOffset(int $yOffset){
		$this->yOffset = $yOffset;
		$this->update(ClientboundMapItemDataPacket::BITFLAG_TEXTURE_UPDATE);
	}

	public function getYOffset(){
		return $this->yOffset;
	}

}