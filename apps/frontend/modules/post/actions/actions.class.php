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

    $this->setTemplate('new');
  }

	public function executeMessages(sfWebRequest $request)
	{
		$lat = $request->getParameter("lat").".".$request->getParameter("lat2");
		$lng = $request->getParameter("lng").".".$request->getParameter("lng2");
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
      $post = $form->save();

      $this->redirect('post/new?id='.$post->getId());
    }
  }
}
