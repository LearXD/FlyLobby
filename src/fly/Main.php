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

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\network\protocol\{

	SetPlayerGameTypePacket};

use pocketmine\utils\Config;

use pocketmine\Player;

class Main extends PluginBase implements Listener {

	

	/** @var Config */

	public $config;

	

	/*

	 * @param null

	 * @return null

	*/

	public function onEnable(){

		

		if(!file_exists($folder = $this->getDataFolder())){

			mkdir($folder);

		}

		

		$this->saveResource('config.yml', false);

		$this->config = new Config($folder . 'config.yml', Config::YAML, array());

		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		$this->getServer()->getPluginManager()->registerEvents(new FlyListener($this), $this);

		

		$this->getServer()->getLogger()->info("§r\n§aPlugin: §fFlyLobby\n§aVersion: §f1.0\n§aAuthor: §fLearXD\n§r");

	}

	

	/*

	 * @param Player

	 * @param bool

	 * @return bool

	*/

	public function setPlayerCanFlight(Player $player, bool $bool){

		if($bool){

			$player->setAllowFlight($bool);

			return true;

		} else {

			$player->setAllowFlight($bool);

			$pk = new SetPlayerGameTypePacket();

			$pk->gamemode = Player::SURVIVAL & 0x01;

			$player->dataPacket($pk);

			$player->sendSettings();

			return false;

		}

	}

	

	/*

	 * @param Player

	 * @return bool

	*/

	public function getPlayerCanFlight(Player $player){

		return $player->getAllowFlight();

	}

	

}
