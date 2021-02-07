<?php

# Revision History
# DEVELOPER                     DATE            COMMENTS
#
# Keon Woo Park (1831319)       2020-04-20      Created collection.php file
#
# Keon Woo Park (1831319)       2020-04-30      debug and check
#
#


class collection
{
    # create an empty array
    public $items = array();
    
    # add an item to the array 'items'
    public function add($primary_key, $item)
    {
        $this->items[$primary_key] = $item;
    }
    
    # remove one item from the array
    public function remove($primary_key)
    {
        # if an item that can be accessed by the primary key exists
        if(isset($this->items[$primary_key]))
        {
            # destroy that item from the array
            unset($this->items[$primary_key]);
        }
    }
    
    # get a specific item from the array
    public function get($primary_key)
    {
        # if an item that can be accessed by the primary key exists
        if(isset($this->items[$primary_key]))
        {
            return $this->items[$primary_key];
        }
    }
    
    # return the number of items in the array 'items'
    public function count()
    {
        return count($this->items);
    }
}