<?php

declare(strict_types=1);

namespace TPE\AdvancedPlayerCount;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public $playerList = [];

    public function onEnable() {}

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {

        switch($cmd->getName()){
            case "online":
                $this->openMyCustomForm($sender);
        }
        return true;
    }
    public function openMyCustomForm ($player) {

        $list = [];
        foreach ($this->getServer()->getOnlinePlayers()as $l) {
            $list[] = $l->getName();
        }

        $this->playerList[$player->getName()] = $list;

        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function ($player, array $data = null) {

            if($data === null){
                return true;
            }

            $index = $data[1];

            $playerName = $this->playerList[$player->getName()] [$index];
            $player->sendMessage("You've selected player: " . $playerName);
        });

        $form->setTitle("AdvancedPlayerCount");
        $form->addLabel("Made by TPE");

        $form->addDropdown("Please select a player", $this->playerList[$player->getName()]);

        $form->sendToPlayer($player);

        return $form;
    }
 }


