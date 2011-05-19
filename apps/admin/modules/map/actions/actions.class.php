<?php

/**
 * map actions.
 *
 * @package    Guff
 * @subpackage map
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mapActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->map_views = Doctrine_Core::getTable('MapView')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new MapViewForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new MapViewForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($map_view = Doctrine_Core::getTable('MapView')->find(array($request->getParameter('id'))), sprintf('Object map_view does not exist (%s).', $request->getParameter('id')));
    $this->form = new MapViewForm($map_view);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($map_view = Doctrine_Core::getTable('MapView')->find(array($request->getParameter('id'))), sprintf('Object map_view does not exist (%s).', $request->getParameter('id')));
    $this->form = new MapViewForm($map_view);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($map_view = Doctrine_Core::getTable('MapView')->find(array($request->getParameter('id'))), sprintf('Object map_view does not exist (%s).', $request->getParameter('id')));
    $map_view->delete();

    $this->redirect('map/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $map_view = $form->save();

      $this->redirect('map/edit?id='.$map_view->getId());
    }
  }
  
    public function executeShow(sfWebRequest $request)
    {
        $slug = $request->getParameter('slug');
        
        $this->mapView = Doctrine::getTable('MapView')->findOneBySlug($slug);
        

    }
}
