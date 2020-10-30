## Examples

Creation methods:
```
$libDateTime = new \Lib\DateTime();

$libDateTime->create();    // simple create

$dateTime = $libDateTime->create('2020-10-10', 'Y-m-d');    // create from string

$dateTime = $libDateTime->create(time());    // create from timestamp
```

Receiving methods:
```
$dateTimeString = $libDateTime->getAsString('Y-m-d');    // '2020-10-10'

$timestamp = $libDateTime->getTimestamp();
```

Formatting methods:
```
$dateTimeAsString = $libDateTime->format($libDateTime->create(), 'Y-m-d');    // from instance \DateTime

$dateTimeAsString = $libDateTime->format('2020-10-10', 'd.m.Y', 'Y-m-d');    // from string

$dateTimeAsString = $libDateTime->format(time(), 'Y-m-d');    // from timestamp
```

Modification methods:
```
$dateTime = $libDateTime->create();

$libDateTime->addSeconds($dateTime, 25 * \Lib\DateTime::SECONDS_PER_MINUTE);    // add in minutes
```
