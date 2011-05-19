<?php

/**
 * MapView form base class.
 *
 * @method MapView getObject() Returns the current form's model object
 *
 * @package    Guff
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMapViewForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'pitch'      => new sfWidgetFormInputText(),
      'yaw'        => new sfWidgetFormInputText(),
      'roll'       => new sfWidgetFormInputText(),
      'latitude'   => new sfWidgetFormInputText(),
      'longitude'  => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'slug'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'pitch'      => new sfValidatorInteger(array('required' => false)),
      'yaw'        => new sfValidatorInteger(array('required' => false)),
      'roll'       => new sfValidatorInteger(array('required' => false)),
      'latitude'   => new sfValidatorNumber(array('required' => false)),
      'longitude'  => new sfValidatorNumber(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
      'slug'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'MapView', 'column' => array('name'))),
        new sfValidatorDoctrineUnique(array('model' => 'MapView', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('map_view[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MapView';
  }

}
