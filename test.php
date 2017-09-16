<?php
date_default_timezone_set('UTC');

assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_WARNING, false);
assert_options(ASSERT_BAIL, true);
assert_options(ASSERT_CALLBACK, function ($path, $line, $message) {
    echo "$path:$line   ERROR"."\n";
});

//$pdo = new PDO("sqlite:challenge.sqlite");
$pdo = new PDO("mysql:host=127.0.0.1;dbname=challenge", "root", "root");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// all tests are based on the agenda view, because its structure has been agreed upon
// test dataset has duplicate rows with an updated dog, owner, and worker information
// identical service should have no effect due to the overlap guard that ignores it



// worker latter overwrite
$sql = "
SELECT      worker_name
FROM        agenda
WHERE       worker_phone        = '4575558909'
AND         DATE(service_start) = '2017-04-15'
";
$actual  = $pdo->query($sql)->fetchColumn();
$correct = "Renea2"; // not Renea
assert($actual == $correct);

// owner latter overwrite
$sql = "
SELECT      owner_name
FROM        agenda
WHERE       owner_phone         = '3315558642'
AND         DATE(service_start) = '2017-04-15'
";
$actual  = $pdo->query($sql)->fetchColumn();
$correct = "Selina2"; // not Selina
assert($actual == $correct);

// dog latter overwrite
$sql = "
SELECT      dog_age
FROM        agenda
WHERE       owner_phone         = '3315558642'
AND         dog_name            = 'Buena'
AND         DATE(service_start) = '2017-04-15'
";
$actual  = $pdo->query($sql)->fetchColumn();
$correct = "2"; // not 1
assert($actual == $correct);


// same location should have a distance of 0
$sql = "
SELECT      ROUND(distance, 3)
FROM        agenda
WHERE       owner_phone         = '9445554506'
AND         worker_phone        = '4145557725'
AND         DATE(service_start) = '2017-03-19'
";
$actual  = $pdo->query($sql)->fetchColumn();
$correct = "0";
assert($actual == $correct);

// updated locations should have a known distance
$sql = "
SELECT      ROUND(distance, 3)
FROM        agenda
WHERE       owner_phone         = '3315558642'
AND         worker_phone        = '4575558909'
AND         DATE(service_start) = '2017-04-15'
";
$actual  = $pdo->query($sql)->fetchColumn();
$correct = "0.342"; // default values on http://andrew.hedges.name/experiments/haversine/
assert($actual == $correct);

// service duration formatting
$sql = "
SELECT      service_duration
FROM        agenda
WHERE       owner_phone         = '9445554506'
AND         worker_phone        = '2085551901'
AND         DATE(service_start) = '2017-03-19'
";
$actual  = $pdo->query($sql)->fetchColumn();
$correct = "01:15:00";
assert($actual == $correct);




echo "All tests pass, nice job!\n";
