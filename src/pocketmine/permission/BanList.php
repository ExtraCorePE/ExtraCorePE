<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace pocketmine\permission;

use pocketmine\Server;
use pocketmine\utils\MainLogger;
use pocketmine\utils\Config;

class BanList{

	/** @var string */
	private $config;

	/**
	 * @param string $file
	*/
	public function __construct(Config $config){
		$this->config = $config;
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function isBanned($name){
		$name = strtolower($name);
		return $this->config->exists($name);
	}

	/**
	 * @param string    $target
	 * @param string    $banner
	 * @param string    $reason
	 * @param \DateTime $date
	 *
	 * @return bool
	 */
	public function addBan(string $target, string $banner, string $reason = "Banned by an operator", $date = ""){
		$array = [
			$target => [
				"banner" => $banner,
				"reason" => $reason,
				"until" => $date
			]
		];
		$date = array_merge($this->config->getAll(), $array);
		$this->config->setAll($data);
		$this->save();
	
		return true;
	}
	
	/**
	 * @param string $name
	 */
	public function remove($name){
		$name = $name;
		if($this->config->exists($name)){
			$this->config->remove($name);
			$this->save();
			
			return true;
		}
		return false;
	}
	
	
	public function save(){
		$this->config->save();
	}
	
	public function getEntries(){
		return $this->config->getAll();
	}
	
	public function getReason($name){
		if($this->config->exists($name)){
			$reason = $this->config->getNested($name."reason");
			
			return $reason;
		}
		return false;
	}
	
	public function setReason($name, $reason){
		if($this->config->exists($name)){
			$this->config->setNested($name."reason", $reason);
			
			return true;
		}
		return false;
	}
	
	public function getUntil($name){
		if($this->config->exists($name)){
			$until = $this->config->getNested($name."until");
			
			return $until;
		}
		return false;
	}
	
	public function setUntil($name, $until){
		if($this->config->exists($name)){
			$this->config->setNested($name."until", $until);
			
			return true;
		}
		return false;
	}
}
