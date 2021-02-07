<?php

/*
 *   _                  __   _______  
 * | |                 \ \ / /  __ \ 
 * | |     ___  __ _ _ _\ V /| |  | |
 * | |    / _ \/ _` | '__> < | |  | |
 * | |___|  __/ (_| | | / . \| |__| |
 * |______\___|\__,_|_|/_/ \_\_____/ 
 * 
 * Free software made by LeaXD, for public use and prohibited sale!
 * Don't forget to read read.me to learn how to use it!
*/


namespace fly;

use pocketmine\event\Listener;

use pocketmine\event\player\{
	PlayerJoinEvent
};

use pocketmine\event\entity\{
	EntityTeleportEvent
};

class FlyListener implements Listener {
	
	/** @var Main */
	protected $owner;
	
	/*
	 * @param Main
	*/
	public function __construct(Main $main){
		$this->owner = $main;
	}
	
	/*
	 * @param PlayerJoinEvent
	*/
	public function onPlayerLogin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		
		if($player->isCreative() or $player->isSpectator())
			return false;
			
		if(!$player->hasPermission($this->owner->config->get('fly-lobby-permission')))
			return false;
			
		if(in_array('default', $this->owner->config->get('allowed-levels')) and $player->getServer()->getDefaultLevel() == $player->getLevel()){
			
			if(!$this->owner->getPlayerCanFlight($player)){
				$this->owner->setPlayerCanFlight($player, true);
			}
			
		} elseif(in_array(strtolower($player->getLevel()->getName()), $this->owner->config->get('allowed-levels'))){
			
			if(!$this->owner->getPlayerCanFlight($player)){
				$this->owner->setPlayerCanFlight($player, true);
			}
			
		}
	}
	
	/*
	 * @param EntityTeleportEvent
	*/
	public function onEntityTeleport(EntityTeleportEvent $event){
		$to = $event->getTo(); //vai
		$from = $event->getFrom(); //esta
		$player = $event->getEntity();
		
		if($player->isCreative() or $player->isSpectator())
			return false;
			
		if(!$player->hasPermission($this->owner->config->get('fly-lobby-permission')))
			return false;
			
		if(in_array('default', $this->owner->config->get('allowed-levels')) and $player->getServer()->getDefaultLevel() == $to->getLevel()){
			
			if(!$this->owner->getPlayerCanFlight($player)){
				$this->owner->setPlayerCanFlight($player, true);
			}
			
		} elseif(in_array(strtolower($to->getLevel()->getName()), $this->owner->config->get('allowed-levels'))){
			
			if(!$this->owner->getPlayerCanFlight($player)){
				$this->owner->setPlayerCanFlight($player, true);
			}
			
		} else {
			
			if($this->owner->getPlayerCanFlight($player)){
				$this->owner->setPlayerCanFlight($player, false);
			}
			
		}
		
		
	}
	
}
	