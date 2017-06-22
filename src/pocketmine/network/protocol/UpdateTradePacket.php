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

class UpdateTradePacket extends DataPacket{

	const NETWORK_ID = Info::UPDATE_TRADE_PACKET;

	public $byte1;
	public $byte2;
	public $varint1;
	public $varint2;
	public $isWilling;
	public $traderEid;
	public $playerEid;
	public $displayName;
	public $offers;

	public function decode(){
		$this->byte1 = $this->getByte();
		$this->byte2 = $this->getByte();
		$this->varint1 = $this->getVarInt();
		$this->varint2 = $this->getVarInt();
		$this->isWilling = $this->getBool();
		$this->traderEid = $this->getEntityId();
		$this->playerEid = $this->getEntityId();
		$this->displayName = $this->getString();
		$this->offers = $this->get(true);
	}

	public function encode(){
		$this->reset();
		$this->putByte($this->byte1);
		$this->putByte($this->byte2);
		$this->putVarInt($this->varint1);
		$this->putVarInt($this->varint2);
		$this->putBool($this->isWilling);
		$this->putEntityId($this->traderEid);
		$this->putEntityId($this->playerEid);
		$this->putString($this->displayName);
		$this->put($this->offers);
	}

	/**
	 * @return PacketName|string
	 */
	public function getName() : string{
		return "UpdateTradePacket";
	}

}