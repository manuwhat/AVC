<?php
namespace EZAMA{


    class AVCIterator implements \ArrayAccess, \Iterator, \Countable, \JsonSerializable
    {
        protected $container=array();
        protected $keys=array();
        protected $simple;
        public function __construct($keys, $container)
        {
            $this->container=$container;
            $this->keys=$keys;
            $this->simple=!is_array($container);
        }
        
        public function offsetSet($key, $value)
        {
            isset($key);
            isset($value);
        }
        
        public function offsetGet($key)
        {
            if ($this->isSimple()) {
                return $this->keys[$key];
            } else {
                return $this->keys[array_search($key, $this->keys, true)];
            }
        }
        
        public function offsetExists($key)
        {
            if ($this->isSimple()) {
                return isset($this->keys[$key]);
            } else {
                return false!==array_search($key, $this->keys, true);
            }
        }
        
        public function offsetUnset($key)
        {
            if ($this->isSimple()) {
                unset($this->keys[$key]);
            } else {
                unset($this->container[$k=array_search($key, $this->keys, true)],$this->keys[$k]);
            }
        }
        
        
        public function count()
        {
            return count($this->keys);
        }
        
        public function key()
        {
            if ($this->isSimple()) {
                return key($this->keys);
            } else {
                return $this->keys[key($this->keys)];
            }
        }
        
        public function current()
        {
            if ($this->isSimple()) {
                return current($this->keys);
            } else {
                return current($this->container);
            }
        }
        
        public function rewind()
        {
            if ($this->isSimple()) {
                reset($this->keys);
            } else {
                reset($this->keys);
				reset($this->container);
            }
        }
        
        public function next()
        {
            if ($this->isSimple()) {
                next($this->keys);
            } else {
                next($this->keys)&&next($this->container);
            }
        }
        
        public function valid()
        {
            $key=key($this->keys);
            return null!==$key&&false!==$key;
        }
        
        public function jsonSerialize()
        {
            if ($this->isSimple()) {
                return $this->keys;
            } else {
                $callback = function ($value, $count) {
                    return array($value,$count);
                };
                return array_map($callback, $this->keys, $this->container);
            }
        }
        
        public function isSimple()
        {
            return $this->simple;
        }
    }
}
