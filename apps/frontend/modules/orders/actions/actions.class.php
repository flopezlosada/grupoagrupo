<?php

/**
 * consumer_group actions.
 *
 * @package    grupos_consumo
 * @subpackage consumer_group
 * @author     info@diphda.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ordersActions extends sfActions
{
  public function executeShow(sfWebRequest $request)
  {

    if ($request->hasParameter("detail"))
    {
      $this->detail=$request->getParameter("detail");
    }
    else {
      $this->detail=0;
    }
    
    $this->order=Doctrine::getTable('Orders')
    ->createQuery("t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();

    if ($this->getUser()->getInternalClassName()=='Provider')
    {
      if ($this->getUser()->getInternalUser()->id!=$this->order->provider_id)
      {
        $this->redirect("@homepage");
      }
    }
    elseif($this->getUser()->getInternalClassName()=='Consumer')
    {
      if ($this->getUser()->getInternalUser()->consumer_group_id!=$this->order->consumer_group_id)
      {
        $this->redirect("@homepage");
      }
    }
  }

  public function executePrint(sfWebRequest $request)
  {
    $this->order=Doctrine::getTable('Orders')
    ->createQuery("t")
    ->where("t.slug=?",$request->getParameter("slug"))
    ->fetchOne();

    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Number','Custom'));

    $config = sfTCPDFPluginConfigHandler::loadConfig();
    sfTCPDFPluginConfigHandler::includeLangFile($this->getUser()->getCulture());
    $doc_title    = __('Orden de pedido')." ".$this->order->name;
    $doc_subject  = __("Grupo de consumo: ").$this->order->ConsumerGroup->name." <br/> ".__("Proveedora/or: ").$this->order->Provider->name;
    $doc_keywords = "test keywords";
     

    //create new PDF document (document units are set by default to millimeters)
    $pdf = new sfTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(PDF_AUTHOR);
    $pdf->SetTitle($doc_title);
    $pdf->SetSubject($doc_subject);
    $pdf->SetKeywords($doc_keywords);

    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    //initialize document
     
    $pdf->AddPage();
    $html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
    h1 {
        color:  #003300;
        font-size: 16pt;
        background-color:#D6E9B5;
        border-bottom:1px solid #003300;
        padding:5px;
        margin-bottom:10px;
    }

    h2 {
        color:  #003300;
        font-size: 14pt;
        text-decoration: none;
    }

    h3 {
        color:  #879D90;
        font-size: 12pt;
    }

    th {
        font-weight:bold;
        text-align:center;
    }
    thead
        {
        border: 3px solid #003300;
        }
    td {
        border: 2px solid #003300;
        background-color: #ffffee;
     }
    th.grey{
        color: #003300;
        }

    .resume{
        color: #003300;
        font-family: helvetica;
        font-size: 8pt;
        border: 1px solid #003300;
        background-color: #A4C0F6;
    }

     .detail{
        color: #003300;
        font-family: helvetica;
        font-size: 8pt;
        border: 1px solid #003300;
        background-color: #73EF61;
    }
    .large {
        width:1100px;
        }
    .medium
        {
        width:550px;
        }
    .short
        {
        width:300px;
        text-align:center;
        }
      .order_consumer_detail_odd{
        font_size:11px;
        background-color:#DCDCDC;
        margin:10px;
        padding:10px;
        }
     .order_consumer_detail_even{
        font_size:11px;
        background-color:#D8E4CD;
        margin:10px;
        padding:10px;
        }
       td.consumer {
        width:550px;
        font-weight:bold;
        vertical-align:middle;
        }
</style>
EOF;

    $html.="<h1>".$doc_title."</h1>";
    $html.="<h2>".$doc_subject."</h2>";
    $html.="<h3>".__("Resumen del pedido")."</h3>";
    $html.="<table class=\"resume\" cellpadding=\"11\" cellspacing=\"6\">";
    $html.="<thead>";
    $html.="<tr>";
    $html.="<th class=\"large\">".__("Producto")."</th>";
    $html.="<th class=\"short\">".__("Cantidad")."</th>";
    $html.="<th class=\"short\">".__("Precio Unitario")."</th>";
    $html.="<th class=\"short\">".__("Total")."</th>";
    $html.="</tr>";
    $html.="</thead>";
    $html.="<tbody>";
    foreach($this->order->getAllProducts() as $i=>$provider_product)
    {
      $html.="<tr>";
      $html.="<td class=\"large\">".$provider_product->short_description."</td>";
      $html.="<td class=\"short\">".deleteRightZero($provider_product->getAmountInOrder($this->order->id))." ".$provider_product->PurchaseUnit->name."</td>";
      $html.="<td class=\"short\">".format_currency($provider_product->price,"EUR",$this->getUser()->getCulture())."</td>";
      $html.="<td class=\"short\">".format_currency($provider_product->getAmountInOrder($this->order->id)*$provider_product->price,"EUR",$this->getUser()->getCulture())."</td>";
      $html.="</tr>";
    }
    $html.="</tbody>";
    $html.="<tfooter>";
    $html.="<tr>";
    $html.="<th colspan=\"3\">".__("Total Pedido")."</th>";
    $html.="<th class=\"short\">".format_currency($this->order->getTotalPrice(),"EUR",$this->getUser()->getCulture())."</th>";
    $html.="</tr>";
    $html.="</tfooter>";
    $html.="</table>";



    $html.="<h3>".__("Detalle del pedido")."</h3>";
    $consumers=count($this->order->getConsumers());
    foreach ($this->order->getConsumers() as $i=>$consumer)
    {
      //$odd = fmod(++$i, 2) ? 'odd' : 'even';
      $html.="<table class=\"detail\" cellpadding=\"11\" cellspacing=\"6\">";
      //$html.="<thead>";
      $html.="<tr>";
      $html.="<th class=\"medium\">".__("Consumidora/or")."</th>";
      $html.="<th class=\"medium\">".__("Producto")."</th>";
      $html.="<th class=\"short\">".__("Cantidad")."</th>";
      $html.="<th class=\"short\">".__("Precio Unitario")."</th>";
      $html.="<th class=\"short\">".__("Total")."</th>";
      $html.="</tr>";
      //$html.="</thead>";

      foreach ($consumer->getProductsOrders($this->order->id) as $a=>$consumer_order)
      {
        $html.="<tr>";
        if ($a==0)
        {
          $html.="<td class=\"consumer\" rowspan=\"".count($consumer->getProductsOrders($this->order->id))."\">".$consumer->name."</td>";
        }
        $html.="<td class=\"medium\">".$consumer_order->ProviderProduct->short_description."</td>";
        $html.="<td class=\"short\">".deleteRightZero($consumer_order->amount)." ".$consumer_order->getPurchaseUnitName()."</td>";
        $html.="<td class=\"short\">".format_currency($consumer_order->ProviderProduct->price,"EUR",$this->getUser()->getCulture())."</td>";
        $html.="<td class=\"short\">".format_currency($consumer_order->amount*$consumer_order->ProviderProduct->price,"EUR",$this->getUser()->getCulture())."</td>";
        $html.="</tr>";
      }

      $html.="<tfooter>";
      $html.="<tr>";
      $html.="<th colspan=\"4\">".__("Total Pedido")."</th>";
      $html.="<th class=\"short\">".format_currency($consumer->getTotalPriceOrder($this->order->id),"EUR",$this->getUser()->getCulture())."</th>";
      $html.="</tr>";
      $html.="</tfooter>";
      $html.="</table>";
      $html.="<p></p>";
    }

    //echo $html;
    $pdf->writeHTML($html , true, 0);
    $pdf->Output($this->order->slug.'.pdf', 'I');

    // Stop symfony process
    throw new sfStopException();
  }
}

