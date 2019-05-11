AVC
===



Extends  PHP array_count_values native function  to count any PHP type value in iterable variables


**Requires**: PHP 5.3+


### Why use this instead of native PHP array_count_values function?


Typically you would use it:

1. You need to count values not only in arrays but also in iterator ,generator.
2. You want to count values of other types than integer and string.
.

### How to use it

Require the library by issuing this command:

```bash
composer require manuwhat/avc
```

Add `require 'vendor/autoload.php';` to the top of your script.



```php
require 'AVC.php';//require helpers file

var_dump(count_values(array_merge(range(0, 5), array(array()), array(array()), array(array(6)))));

/* output
array(8) {
  [0]=>
  array(2) {
    [0]=>
    int(0)
    [1]=>
    int(1)
  }
  [1]=>
  array(2) {
    [0]=>
    int(1)
    [1]=>
    int(1)
  }
  [2]=>
  array(2) {
    [0]=>
    int(2)
    [1]=>
    int(1)
  }
  [3]=>
  array(2) {
    [0]=>
    int(3)
    [1]=>
    int(1)
  }
  [4]=>
  array(2) {
    [0]=>
    int(4)
    [1]=>
    int(1)
  }
  [5]=>
  array(2) {
    [0]=>
    int(5)
    [1]=>
    int(1)
  }
  [6]=>
  array(2) {
    [0]=>
    array(0) {
    }
    [1]=>
    int(2)
  }
  [7]=>
  array(2) {
    [0]=>
    array(1) {
      [0]=>
      int(6)
    }
    [1]=>
    int(1)
  }
}

*/
```
AS you may see the result is a multi-dimensional array and this is great but not very convenient.
So the package provide an iterator to easily handle the result.One can use it this way:

```php
require 'AVC.php';//require helpers file

$x=count_values(array_merge(range(0, 5), array(array()), array(array()), array(array(6))),true);

foreach ($x as $value=>$count){
	if(is_array($value)||is_object($value)){
		var_dump($value);
	}elseif(is_resource($value)){
		var_dump(stream_get_meta_data ($value));
	}else{
		echo "$value=>$count<br>";
	}

}

```
When the handled variable doesn't contain type other than integer or string the function return exactly the same output
as the native array_count_values function except if an iterator have been required.

Note that when the handled variable contain types other than integer and string and an iterator has been required as result,
you can access the count using array access syntax .For example:
 
 ```php
require 'AVC.php';//require helpers file

$x=count_values(array_merge(range(0, 5), array(array()), array(array()), array(array(6))),true);

echo $x[array()];
/*
output:
2
*/
```

3 helpers are provided in the AVC.php file 

count_values,value_count,count_diff_values


To run unit tests 
```bash
phpunit  ./tests
```
