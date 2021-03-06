<?php

/**
 * BaseHashList
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $tag
 * 
 * @method integer  getId()  Returns the current record's "id" value
 * @method string   getTag() Returns the current record's "tag" value
 * @method HashList setId()  Sets the current record's "id" value
 * @method HashList setTag() Sets the current record's "tag" value
 * 
 * @package    Guff
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseHashList extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hash_list');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('tag', 'string', 25, array(
             'type' => 'string',
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}