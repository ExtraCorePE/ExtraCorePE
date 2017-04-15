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
			return $this->config->exists(strtolower($name));
		}
	}

	/**
	 * @param string    $target
	 * @param string    $reason
	 * @param \DateTime $expires
	 *
	 * @return bool
	 */
	public function addBan(string $target, string $reason = "", $expires = ""){
		$this->config->setNested($target."reason", $reason);
		$this->config->setNested($target."date", $expires);
		
		$this->save();
		
		return $true;
	}
}
