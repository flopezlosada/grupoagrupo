<?php

class ordersCloseOrdersTask extends sfBaseTask
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

    $this->namespace        = 'orders';
    $this->name             = 'closeOrders';
    $this->briefDescription = 'Close an order when the date_out is reached';
    $this->detailedDescription = <<<EOF
The [orders:closeOrders|INFO] task does things.
Call it with:

  [php symfony orders:closeOrders|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    
    $query=Doctrine::getTable("Orders")->createQuery()->where("order_state_id=?",1)->andWhere("date_out=?",date("Y-m-d"))->execute();
    foreach($query as $order)
    {
        $order->order_state_id=2;
        $order->group_close_date=date("Y-m-d");
        $order->save();
    }
    
  $query=Doctrine::getTable("Orders")->createQuery()->where("order_state_id=?",13)->andWhere("date_in=?",date("Y-m-d"))->execute();
    foreach($query as $order)
    {
        $order->order_state_id=1;
        $order->save();
    }
    
    
  }
}
