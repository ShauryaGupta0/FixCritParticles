<?php

namespace ShauryaGupta06\FixCrit;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ResourcePackStackPacket;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    const CHEMISTRY_PACK_ID = "0fba4063-dba1-4281-9b89-ff9390653530";

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDataPacketSend(DataPacketSendEvent $event){
        $packets = $event->getPackets();
        foreach ($packets as $key => $pk) {
            if ($pk instanceof ResourcePackStackPacket) {
                $packStack = $pk->resourcePackStack;
                foreach ($packStack as $i => $resourcePack) {
                    if ($resourcePack->getPackId() === self::CHEMISTRY_PACK_ID) {
                        unset($packStack[$i]);
                    }
                }
                $pk->resourcePackStack = array_values($packStack);
                $packets[$key] = $pk;
            }
        }
        $event->setPackets($packets);
    }
}
