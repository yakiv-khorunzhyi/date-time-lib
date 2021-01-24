## Examples

Creation methods:
```
$dateTimeFacade = new \Library\DateTime\Facade();

$dateTime = $dateTimeFacade->create();    // returned object \Library\DateTimeInterface

$dateTime = $dateTimeFacade->createFromString(
    '2020-10-10', 
    \Library\DateTime\Format::DATE_DASH, 
    \Library\DateTime\TimeZone::UTC
);

$dateTime = $dateTimeFacade->createFromTimestamp(time());

$dateTime = $dateTimeFacade->createFromDate(2020, 10, 10);

$dateTime = $dateTimeFacade->createFromJson('{
    "date_time": "2020-11-11 12:12:12",
    "time_zone": "UTC"
}');

```

Receiving methods:
```
$dateTimeString = $dateTimeFacade->now('Y-m-d');    // '2020-10-10'

$timestamp = $dateTimeFacade->nowTimestamp();
```

Formatting methods:
```
$dateTimeAsString = $dateTimeFacade->formatDateTime(new \DateTime('now'), 'Y-m-d');

$dateTimeAsString = $dateTimeFacade->formatString('2020-10-10', 'd.m.Y', 'Y-m-d');

$dateTimeAsString = $dateTimeFacade->formatTimestamp(time(), 'Y-m-d');
```

Time zone methods: 
```
$timeZoneName = $dateTimeFacade->getTimeZoneName();    // 'UTC'

$assocArr = $dateTimeFacade->getAllTimeZones();    // [ "Pacific/Wallis" => "+12:00", ... ]

$offset = $dateTimeFacade->getTimeZoneOffset();    //"+00:00"
```

Validation:
```
$isValid = $dateTimeFacade->isValidFormat('2020-10-10', 'Y-m-d');
```

Сonverting:
```
$json = $dateTimeFacade->convertToJson($dateTime);    //"{"date_time":"2021-01-24 13:06:24","time_zone":"UTC"}"
```
