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

	/** @var bool */
	private $enabled = true;

	/**
	 * @param string $file
	*/
	public function __construct(Config $config){
		$this->config = $config;
	}

	/**
	 * @return bool
	 */
	public function isEnabled(){
		return $this->enabled === true;
	}

	/**
	 * @param bool $flag
	 */
	public function setEnabled($flag){
		$this->enabled = (bool) $flag;
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function isBanned($name){
		$name = strtolower($name);
		if(!$this->isEnabled()){
			return false;
		}else{
			return $this->config->exists($name);
		}
	}

	/**
	 * @param string    $target
	 * @param string    $reason
	 * @param \DateTime $until
	 *
	 * @return bool
	 */
	public function addBan(string $target, string $reason = "Banned by an operator", $until = ""){
		$this->config->setNested($target."reason", $reason);
		$this->config->setNested($target."until", $until);
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
