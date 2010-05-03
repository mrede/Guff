<?php

/**
 * Post form.
 *
 * @package    Guff
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PostForm extends BasePostForm
{
  public function configure()
  {
		unset(
			$this['created_at'],
			$this['updated_at'],
			$this['ip']
			);
		
		$this->widgetSchema['text'] = new sfWidgetFormTextarea();
		$this->widgetSchema['latitude'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['longitude'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['accuracy'] = new sfWidgetFormInputHidden();
		
		$this->widgetSchema->setLabel("text", "Your message");
  }

	public function doSave($con = null) 
	{
		$this->object->setIp(sfContext::getInstance()->getRequest()->getHttpHeader ('addr','remote'));
		parent::doSave($con);
	}
}
