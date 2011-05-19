<?php

/**
 * post actions.
 *
 * @package    Guff
 * @subpackage post
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class postActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  
  public function executeMessages(sfWebRequest $request)
	{
		$lat = $request->getParameter("lat").".".$request->getParameter("lat2");
		$lng = $request->getParameter("lng").".".$request->getParameter("lng2");
		$this->logMessage("MEssages $lat, $lng");
		$postExecute = false;


		
		$posts = Doctrine::getTable('Post')->getNearby($lat, $lng, 2);
		$this->setLayout(false);
		
		$this->json = '{"posts": [';
		foreach ($posts as $p)
		{
		    $this->json .= json_encode($p->toAdminArray()).',';
		}
		if (count($posts)>0) {
		    //drop last
		    $this->json  = substr($this->json, 0, -1);
	    }
		if ($postExecute) {
		    $this->logMessage("We have a post ID, send this too");
		    $this->json .='], "pID": "'.$this->post->getId().'"} ';
		} else {
		    $this->json .=']} ';
	    }
		$this->getResponse()->setHttpHeader('Content-type','application/json');
	}
	
}
