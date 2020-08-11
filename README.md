# ScheduleAPI
PocketMine-MP Make it easy for developers to use scheduler task

# How use?

```php
use skh6075\ScheduleAPI\ScheduleAPI;
```

# ScheduleAPI DelayedTask
```php
$main = $this;

ScheduleAPI::delayedTask (function () use ($main) {
    $main->getLogger ()->info ('Alert in 2 seconds');
}, 20 * 2);
```

# ScheduleAPI RepeatingTask
```php
$main = $this;

ScheduleAPI::repeatingTask (function () use ($main) {
    $main->getLogger ()->info ('two-second repetition');
}, 20 * 2);
```
