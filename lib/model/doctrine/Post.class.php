<?php

/**
 * Post
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Guff
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Post extends BasePost
{
    public function toPublicArray()
	{
	    $arr = array();
	    $arr['t'] = $this->getText();
	    $now = intval(Date('U', time()));
	    $exp = intval(Date('U', strtotime('+2 hour', strtotime($this->getCreatedAt()))));
	    $arr['e'] = ($exp-$now);
	    return $arr;
	}
	
}
