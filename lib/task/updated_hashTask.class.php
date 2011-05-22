<?php

class updated_hashTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'updated_hash';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [updated_hash|INFO] task does things.
Call it with:

  [php symfony updated_hash|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    //Get All Hashes in last 24 Hours
    $recent = HashListTable::getInstance()->getRecent();
    print count($recent);
    $map = array();
    foreach ($recent as $r)
    {
        if (isset($map[$r->getTag()]))
        {
            $map[$r->getTag()] = $map[$r->getTag()]+1;
        } 
        else
        {
            $map[$r->getTag()] = 1;
        }
    }
    
    print_r($map);
  }
}
