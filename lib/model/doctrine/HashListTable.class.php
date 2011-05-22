<?php

/**
 * HashListTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class HashListTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object HashListTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('HashList');
    }
    
    public function getRecent()
   	{
   		$date = date('Y-m-d H:i:s', time()-86400);

        $q = $this->createQuery()
   						->addWhere('created_at > "'.$date.'"')
   						->orderBy("created_at desc");
   		return $q->execute();
   	}
}