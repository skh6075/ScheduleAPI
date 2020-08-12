<?php

namespace skh6075\ScheduleAPI;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskHandler;

use function class_exists;

class ScheduleAPI extends PluginBase {

    public static $tasks = [];
    
    public static $i;
    
    
    public function onLoad (): void{
        if (!class_exists (TaskHandler::class)) {
            throw new \InvalidStateException ('not founded TaskHandler class.');
        }
        self::$i = $this;
    }
    
    /**
     * @param callable $callback
     * @return Task
     */
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
    
    /**
     * @param callable $callback
     * @param int $ticks
     * @return TaskHandler
     */
    public static function delayedTask (callable $callback, int $ticks): TaskHandler{
        $handler = self::$i->getScheduler ()->scheduleDelayedTask (($task = self::taskHandler ($callback)), $ticks);
        self::$tasks [$task->getTaskId ()] = $handler;
        return $handler;
    }
    
    /**
     * @param callable $callback
     * @param int $ticks
     * @return TaskHandler
     */
    public static function repeatingTask (callable $callback, int $ticks): TaskHandler{
        $handler = self::$i->getScheduler ()->scheduleRepeatingTask (($task = self::taskHandler ($callback)), $ticks);
        self::$tasks [$task->getTaskId ()] = $handler;
        return $handler;
    }
    
    /**
     * @param callable $callback
     * @param int $delay
     * @param int $ticks
     * @return TaskHandler
     */
    public static function delayedRepeatingTask (callable $callback, int $delay = 0, int $ticks): TaskHandler{
        $handler = self::$i->getScheduler ()->scheduleDelayedRepeatingTask (($task = self::taskHandler ($callback)), $delay, $ticks);
        self::$tasks [$task->getTaskId ()] = $handler;
        return $handler;
    }
    
    /**
     * @param int $taskId
     * @return TaskHandler|null
     */
    public static function getTaskHandler (int $taskId): ?TaskHandler{
        return self::$tasks [$taskId] ?? null;
    }
    
    /**
     * @param int $taskId
     */
    public static function cancelTask (int $taskId): void{
        if (($handler = self::getTaskHandler ($taskId)) instanceof TaskHandler) {
            self::$i->getScheduler ()->cancelTask ($handler->getTaskId ());
        }
    }
    
}