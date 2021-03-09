<?php 
require_once __DIR__."/../vendor/autoload.php";

run('shouldBeCommutative');
run('shouldBeAssociative');
function run(string $test){
    if(true=== call_user_func($test)){
        echo "✅ Success: ". (string) $test."\n";
    }else{
        echo "❌ Fail: ".  (string) $test."\n";
    }
}
