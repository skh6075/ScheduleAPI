# ScheduleAPI
PocketMine-MP Make it easy for developers to use scheduler task

### How use?

```php
use skh6075\ScheduleAPI\ScheduleAPI;
```

### ScheduleAPI DelayedTask
```php
$main = $this;

ScheduleAPI::delayedTask (function () use ($main) {
    $main->getLogger ()->info ('Alert in 2 seconds');
}, 20 * 2);
```

### ScheduleAPI RepeatingTask
```php
$main = $this;

ScheduleAPI::repeatingTask (function () use ($main) {
    $main->getLogger ()->info ('two-second repetition');
}, 20 * 2);
```

### ScheduleAPI DelayedRepeatingTask
```php
$main = $this;
$delayTicks = 20 * 2;
$ticks = 20 * 2;

ScheduleAPI::delayedRepeatingTask (function () use ($main) {
    $main->getLogger ()->info ('repeat delayed two-second');
}, $delayTicks, $ticks);
```

### ScheduleAPI Function cancelTask
```php
$taskHandler = ScheduleAPI::repeatingTask (function () {
    var_dump ('hello world');
}, 20 * 2);
ScheduleAPI::cancelTask ($taskHandler->getTaskId ());
```
