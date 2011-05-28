<?php

/**
 * HashStat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Guff
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class HashStat extends BaseHashStat
{
    protected $rank;
    
    public function getRank()
    {
        return $this->rank;
    }
    
    public function setRank($val)
    {
        $this->rank = $val;
    }
    
    public function toPublicArray()
   	{
   	    $arr = array();
   	    $arr['tag'] = $this->getTag();
   	    $arr['rank'] = $this->rank;
   	    return $arr;
   	}
}
