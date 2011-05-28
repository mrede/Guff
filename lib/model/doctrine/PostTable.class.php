<?php


class PostTable extends Doctrine_Table
{
    
	public static function getInstance()
	{
		return Doctrine_Core::getTable('Post');
	}

	public function getNearby($lat, $lng, $defaultRadius = 0.2)
	{

		$q = $this->createQuery()
					->from('Post a')
	        ->addSelect("((acos( cos( radians($lat) ) * cos( radians( a.latitude ) ) * cos( radians( a.longitude ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( a.latitude ) ) )) * 6371) as distance, a.* ")
	        ->addWhere('created_at > "'.date('Y-m-d H:i:s', strtotime('-2 hours')).'"')
	        ->addHaving("distance < ".$defaultRadius)
	        ->orderBy('a.created_at desc');



		return $q->execute();
		
	}
	

	public function getRecent()
	{
		$q = $this->createQuery()
						->limit(20)
						->orderBy("created_at desc");
		return $q->execute();
	}
}