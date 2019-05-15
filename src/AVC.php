<?php
namespace EZAMA{
    class AVC
    {
        public static function countValues($mixed, $getIterator=false)
        {
            if (is_array($mixed)) {
                self::handleArray($mixed, $countKeys, $response, $simple);
            } else {
                self::handleNotArray($mixed, $countKeys, $response, $simple);
            }

            if ($getIterator) {
                return self::getIterator($simple, $response, $countKeys);
            } else {
                return self::getResponse($simple, $response, $countKeys);
            }
        }

        public static function countDiffValues($mixed)
        {
            return count((array)self::countValues($mixed));
        }

        public static function valueCount($value, $mixed)
        {
            $iterator=self::countValues($mixed, true);
            return (int)$iterator[$value];
        }
        
        private static function handleNotArray($mixed, &$countKeys, &$response, &$simple)
        {
            $countKeys=array();
            $response=array();
            $simple=true;

            if ((is_object($mixed)&&key_exists('Traversable', class_implements($mixed)))) {
                self::hNALoop($mixed, $simple, $response, $countKeys);
            } else {
                $response[]=$mixed;
                $countKeys[]=1;
            }
        }
        
        private static function hNALoop($mixed, &$simple, &$response, &$countKeys)
        {
            $i=0;
            foreach ($mixed as $k=>$val) {
                if (!is_int($val)&&!is_string($val)) {
                    $simple=false;
                }
                if (($offset=array_search($val, $response, true))===false) {
                    $response[$i]=$val;
                    $countKeys[$i++]=1;
                } else {
                    $countKeys[$offset]++;
                }
            }
        }
        
        private static function handleArray($array, &$countKeys, &$response, &$simple)
        {
            $i=0;
            $countKeys=array();
            $simple=true;
            $callback=function ($carry, $item) use (&$i, &$countKeys, &$simple) {
                if (!is_array($carry)) {
                    $carry=array();
                }
                if (!is_int($item)&&!is_string($item)) {
                    $simple=false;
                }
                if (false===$k=array_search($item, $carry, true)) {
                    $carry[$i]=$item;
                    $countKeys[$i++]=1;
                } else {
                    $countKeys[$k]++;
                }
                return $carry;
            };
            $response=array_reduce($array, $callback);
        }
        
        private static function getIterator($simple, $response, $countKeys)
        {
            return $simple ?
            new AVCIterator(array_combine($response, $countKeys), null) : new AVCIterator($response, $countKeys);
        }
        
        private static function getResponse($simple, $response, $countKeys)
        {
            $callback=function ($value, $count) {
                return array($value, $count);
            };
            return $simple ?
            array_combine($response, $countKeys) : array_map($callback, $response, $countKeys);
        }
    }
}
