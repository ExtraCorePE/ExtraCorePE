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

namespace pocketmine\network\protocol;

class BossEventPacket extends DataPacket{

	const NETWORK_ID = Info::BOSS_EVENT_PACKET;

  	public $eid;
	public $type;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid);
		$this->putUnsignedVarInt($this->type);
	}

	/**
	 * @return PacketName|string
	*/
	public function getName() : string{
		return "BossEventPacket";
	}

}
