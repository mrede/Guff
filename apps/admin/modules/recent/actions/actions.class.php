<?php

/**
 * recent actions.
 *
 * @package    Guff
 * @subpackage recent
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class recentActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //Get most recent posts
		$this->posts = PostTable::getInstance()->getRecent();
		$this->centerLat = $this->centerLng = 0;
  }
}
