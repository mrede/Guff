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
    //$this->setTemplate('messages');
    //$this->executeMessages($request);
    //$this->forward('post','messages');
    
  }

	public function executeMessages(sfWebRequest $request)
	{
		$lat = $request->getParameter("lat").".".$request->getParameter("lat2");
		$lng = $request->getParameter("lng").".".$request->getParameter("lng2");
		$this->logMessage("MEssages $lat, $lng");
		//try post
	/*	if (strlen($lat)==1) {
		    
		    $lat = '51.57';//$request->getParameter("post[latitude]");
    		$lng = '-0.106';//$request->getParameter("post[longitude]");
    		$this->logMessage("ALT LAT LNG = $lat, $lng");
		}*/
		
		$posts = Doctrine::getTable('Post')->getNearby($lat, $lng);
		$this->setLayout(false);
		
		$this->json = '{"posts": [';
		foreach ($posts as $p)
		{
		    $this->json .= json_encode($p).',';
		}
		//drop last
		$this->json  = substr($this->json, 0, -1);
		$this->json .=']} ';
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

      if (!$request->isXmlHttpRequest())
      {
          $this->redirect('post/new?id='.$this->post->getId());
      }
    }
  }
}
