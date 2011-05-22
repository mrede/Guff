<?php

/**
 * HashStatTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class HashStatTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object HashStatTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('HashStat');
    }
    
    public function deleteAll()
    {
        $recs = $this->findAll();
        foreach ($recs as $r)
        {
            $r->delete();
        }
    }
    
    public function getTopFive()
    {
        $q = $this->createQuery()
                        ->limit(5)
   						->orderBy("total desc");
   		
   		$stats =  $q->execute();
   		
        $rank=5;
        foreach ($stats as $t) {
            $t->setRank($rank);
            $rank--;
        }
        
        return $stats;
    }
}