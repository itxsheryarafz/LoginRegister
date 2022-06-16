<?php
$arr1 = array('one' => 'foo');
$arr2 = array('two' => 'bar');

// Will contain array('one' => 'foo', 'two' => 'bar');
$combined = $arr1 + $arr2;

print_r($combined);
?>