<?php

/**
 * @name ScheduleAPI
 * @main skh6075\ScheduleAPI\ScheduleAPI
 * @author AvasKr
 * @version 1.0.0
 * @api 3.10.0
 * @website https://github.com/GodVas
 */

namespace skh6075\ScheduleAPI;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskHandler;

class ScheduleAPI extends PluginBase {

    public static $tasks = [];
    
    public static $i;
    
    
    public function onLoad (): void{
        self::$i = $this;
    }
    
    
    public static function taskHandler (callable $callback): Task{
        return new class ($callback) extends Task {
        
            public function __construct (callable $callback) {
                $this->callback = $callback;
            }
            
            public function onRun (int $currentTick): void{
                $callback = $this->callback;
                $callback();
            }
        };
    }
    
    public static function delayedTask (callable $callback, int $ticks): TaskHandler{
        $handler = self::$i->getScheduler ()->scheduleDelayedTask (($task = self::taskHandler ($callback)), $ticks);
        self::$tasks [$task->getTaskId ()] = $handler;
        return $handler;
    }
    
    public static function repeatingTask (callable $callback, int $ticks): TaskHandler{
        $handler = self::$i->getScheduler ()->scheduleRepeatingTask (($task = self::taskHandler ($callback)), $ticks);
        self::$tasks [$task->getTaskId ()] = $handler;
        return $handler;
    }
    
}
