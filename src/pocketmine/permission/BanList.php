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
	public function removeBan($name){
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
