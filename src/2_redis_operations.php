<?php
require "1_connect_redis.php";

// 1. SET, GET, and EXISTS
$redis->set("sample key 1", "sample value!");
$value = $redis->get("sample key 1");
var_dump($value);

echo ($redis->exists("sample key 2")) ? "true" : "false";


// 2. INCR (INCRBY) and DECR (DECRBY)
$redis->set("article_views_234", 200);

// increment the number of views by 1 for an article with id 234
$redis->incr("article_views_234");
$value = $redis->get("article_views_234");
var_dump($value);

// increment views for article 237 by 5
$redis->incrby("article_views_237", 5);

// decrement views for article 237
$redis->decr("article_views_237");

// decrement views for article 237 by 3
$redis->decrby("article_views_234", 3);
$value = $redis->get("article_views_234");
var_dump($value);


// 3. Redis Data Types: String, List, Hash, Set, Sorted set
// Hash - you can represent objects (think of it as a one-level deep JSON object)
// HSET, HGET and HGETALL, HINCRBY, and HDEL
$redis->hset("taxi_car", "brand", "Toyota");
$redis->hset("taxi_car", "model", "Yaris");
$redis->hset("taxi_car", "license number", "RO-01-PHP");
$redis->hset("taxi_car", "year of fabrication", 2010);
$redis->hset("taxi_car", "nr_starts", 0);
/*
$redis->hmset("taxi_car", array(
    "brand" => "Toyota",
    "model" => "Yaris",
    "license number" => "RO-01-PHP",
    "year of fabrication" => 2010,
    "nr_stats" => 0)
);
*/
echo "License number: " .
    $redis->hget("taxi_car", "license number") . "<br>";

// remove license number
$redis->hdel("taxi_car", "license number");

// increment number of starts
$redis->hincrby("taxi_car", "nr_starts", 1);

$taxi_car = $redis->hgetall("taxi_car");
echo "All info about taxi car";
echo "<pre>";
var_dump($taxi_car);
echo "</pre>";


// 4. LPUSH, RPUSH, LPOP, RPOP, LLEN, LRANGE
// These are the important commands for working with the list type in Redis
// LPUSH – prepends element(s) to a list.
// RPUSH – appends element(s) to a list.
// LPOP – removes and retrieves the first element of a list.
// RPOP – removes and retrieves the last element of a list.
// LLEN – gets the length of a list.
// LRANGE – gets elements from a list.
$list = "PHP Frameworks List";
$redis->rpush($list, "Symfony 2");
$redis->rpush($list, "Symfony 1.4");
$redis->lpush($list, "Zend Framework");

echo "Number of frameworks in list: " . $redis->llen($list) . "<br>";

$arList = $redis->lrange($list, 0, -1);
echo "<pre>";
print_r($arList);
echo "</pre>";

// the last entry in the list
echo $redis->rpop($list) . "<br>";

// the first entry in the list
echo $redis->lpop($list) . "<br>";



// 5. EXPIRE , EXPIREAT , TTL, and PERSIST
// Most likely, when you set a key you don’t want it to be saved forever because
// after a certain period of time it’s not likely to be relevant anymore.

// set the expiration for next week
$redis->set("expire in 1 week", "I have data for a week");
$redis->expireat("expire in 1 week", strtotime("+1 week"));
$ttl = $redis->ttl("expire in 1 week"); // will be 604800 seconds

// set the expiration for one hour
$redis->set("expire in 1 hour", "I have data for an hour");
$redis->expire("expire in 1 hour", 3600);
$ttl = $redis->ttl("expire in 1 hour"); // will be 3600 seconds

// never expires
$redis->set("never expire", "I want to leave forever!");
