<?php
/*
 © Copyright 2012 diphda.net && Sodepaz
info@diphda.net


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin l
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt*/
class providerComponents extends sfComponents
{
  public function executePopular(sfWebRequest $request)
  {
    $this->consumer_orders=Doctrine::getTable("ConsumerOrder")
    ->createQuery()->select("count(*) as p, product_id")
    ->where("provider_id=?",$this->getUser()->getInternalUser()->id)
    ->groupBy("product_id")
    ->orderBy("p desc")
    ->limit(10)
    ->execute();

    $products=array();
    foreach ($this->consumer_orders as $order)
    {
      $products[]=$order->product_id;
    }
    /*
     * para mantener el orden tengo que pasar un texto
    * con el resultado del array convertido a texto separado por comas
    * que luego se introducen en la consulta en el order by
    */
    $products_implode=implode(', ', $products);

    $this->provider_products=Doctrine::getTable("ProviderProduct")->createQuery()->whereIn("id",$products)->orderBy("field (id,$products_implode)")->execute();

  }

  public function executeCategories(sfWebRequest $request)
  {

    if ($this->getUser()->hasCredential("producer")||$this->getUser()->hasCredential("distributor"))
    {    

      if ($request->hasParameter("provider_id"))
      {
        $this->provider = Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
      }
      else
      {
        $this->provider = $this->getUser()->getInternalUser();
      }
    }
    else
    {
      if ($request->hasParameter("provider_id"))
      {
        $this->provider = Doctrine::getTable("Provider")->findOneById($request->getParameter("provider_id"));
      } elseif ($request->hasParameter("slug"))
      {
        $this->provider = Doctrine::getTable("Provider")->findOneBySlug($request->getParameter("slug"));
      }
    }
     
    $query=Doctrine::getTable("ProviderProduct")->createQuery()->where("provider_id=?",$this->provider->id)->andWhere("is_active=?",1)->execute();
    $array_categories=array();
    foreach ($query as $provider_product)
    {
      $array_categories[]=$provider_product->product_category_id;
    }

    if (count($array_categories))
    {
      $this->categories=Doctrine::getTable("ProductCategory")->createQuery()->whereIn("id",$array_categories)->orderBy("id")->execute();
    }
    else {
      $this->categories=null;
    }

    $this->request_category=0;
    $this->request_subcategory=0;
    /*
     * en el caso de que estén definidas category_id y subcategory_id, es decir, que se haya
    * pinchado en el enlace del menú, hay que encontrar el valor de la clave del array de
    * ids de categorías que corresponde a la categoría escogida.
    * Es para que se quede abierto el acordeón en esa categoría. Y como el acordeón sólo entiende
    * del orden de las categorías que se le pasan, pues hay que encontrarlo.
    */
    if ($request->getParameter("category_id"))
    {
      $categories_id=array();
      foreach ($this->categories as $cat)
      {
        $categories_id[]=$cat->id;
      }
      //este es el valor del orden
      $this->request_category=array_search($request->getParameter("category_id"),$categories_id);

      // esto es para poner activo en el class del listado
      $this->request_subcategory=$request->getParameter("subcategory_id");
    }

    if ($request->getParameter("buy_consumer_id"))
    {
      $this->buyConsumer=Doctrine::getTable("Consumer")->findOneById($request->getParameter("buy_consumer_id"));
    }
  }

  public function executeWarning(sfWebRequest $request)
  {
    if ($this->getUser()->getInternalClassName()=="Provider")
    {
      if (!$this->getUser()->getInternalUser()->hasCatalogue())
      {
        $this->warning_catalogue=true;
      }
      else {
        $this->warning_catalogue=false;
      }
    }
  }
}