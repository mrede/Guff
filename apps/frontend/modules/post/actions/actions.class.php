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
  public function executeIndex(sfWebRequest $request)
  {
   
		


  }
  
  public function executeHashRanking(sfWebRequest $request)
  {
      $stats = HashStatTable::getInstance()->getTopFive();
      $this->json = '{"stats": [';
      foreach ($stats as $s) {
          $this->json .= json_encode($s->toPublicArray()).',';
      }
      //Remove last comma
      $this->json = substr($this->json, 0, -1);
      $this->json .=']} ';
      $this->setLayout(false);
      $this->getResponse()->setHttpHeader('Content-type','application/json');
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PostForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PostForm();

    $this->processForm($request, $this->form);
    $this->setLayout(false);
    $this->setTemplate('messages');
    $this->logMessage("End of Create");
    $this->executeMessages($request);
    //$this->forward('post','messages');
    //$this->redirect('/post/messages/'.$this->post->getLatitude().'/'.$this->post->getLongitude().'/'.$this->post->getId());
    //return false;
  }

	public function executeMessages(sfWebRequest $request)
	{
		$lat = $request->getParameter("lat").".".$request->getParameter("lat2");
		$lng = $request->getParameter("lng").".".$request->getParameter("lng2");
		$this->logMessage("MEssages $lat, $lng");
		$postExecute = false;
		//try post
		if (strlen($lat)==1) {
		    
		    $lat = $this->post->getLatitude();//'51.57';//$request->getParameter("post[latitude]");
    		$lng = $this->post->getLongitude();//'-0.106';//$request->getParameter("post[longitude]");
    		$this->logMessage("ALT LAT LNG = $lat, $lng");
    		$postExecute = true;
		}
		
		$posts = Doctrine::getTable('Post')->getNearby($lat, $lng);
		$this->setLayout(false);
		
		$this->json = '{"posts": [';
		foreach ($posts as $p)
		{
		    $this->json .= json_encode($p->toPublicArray()).',';
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

	public function executeLoadMap(	sfWebRequest $request)
  {
		$this->form = new PostForm();
	}
	
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->post = $form->save();
      $this->post->setText(strip_tags($this->post->getText()));
      $this->post->save();
      $this->post->parseHashTags();
      $this->logMessage("TEXT:".$this->post->getText());
      $this->logMessage("About to push");
      $pusher = new Pusher('6b5e2c3e82788a7a4422', '83a0dd059dcc0e4e6ef9', '4844');
      
      //Get channel name
     //// var lat = String(Math.round($('body').data('lat')*1000)).replace("-", "m");
     // var lng = String(Math.round($('body').data('lng')*1000)).replace("-", "m");
	//	var channelName = lat+"_"+lng;
        $lat = str_replace('-', 'm', round($this->post->getLatitude()*1000));
        $lng = str_replace('-', 'm', round($this->post->getLongitude()*1000));
        $this->logMessage("Pushing to channel $lat _ $lng");
        $pusher->trigger('c'.$lat.'_'.$lng, 'new_guff', $this->post->getText(), $request->getParameter('sockID'));
        $this->logMessage("PUSHED");
        
        $lat = str_replace('-', 'm', round($this->post->getLatitude()*10));
        $lng = str_replace('-', 'm', round($this->post->getLongitude()*10));
        $this->logMessage("Pushing to channel $lat _ $lng");
        $pusher->trigger('c'.$lat.'_'.$lng, 'new_guff', $this->post->getText(), $request->getParameter('sockID'));
        $this->logMessage("PUSHED");

      if (!$request->isXmlHttpRequest())
      {
          $this->logMessage("Not XML request");
          
          $this->redirect('post/new?id='.$this->post->getId());
      }
    }
    else
    {
        $this->logMessage("INVALID FORM");
        $this->logMessage($form->renderGlobalErrors());
    }
  }
}
