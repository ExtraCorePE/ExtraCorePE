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

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;
use pocketmine\item\Item;

class ItemCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"Check item information command",
			"Usage: /item"
		);
		$this->setPermission("pocketmine.command.item.player");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if($sender instanceof Player){
			if(!$this->testPermission($sender)){
				return true;
			}

			if(count($args) >= 1){
				$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

				return false;
			}

			$item = $sender->getInventory()->getItemInHand();
			$sender->sendMessage("ItemName(".$item->getName().") Id(".$item->getId().":".$item->getDamage().")");
		}else{
			$sender->sendMessage(new TranslationContainer("commands.generic.player.notFound"));
		}

		return true;
	}
}
