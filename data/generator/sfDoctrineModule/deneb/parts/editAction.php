  public function executeEdit(sfWebRequest $request)
  {
  	if ($request->getParameter("cultureTranslation"))
    {
    	$this->cultureTranslation=$request->getParameter("cultureTranslation");
        sfContext::getInstance()->getUser()->setFlash("cultureTranslation",$request->getParameter("cultureTranslation"));
	}
    $this-><?php echo $this->getSingularName() ?> = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this-><?php echo $this->getSingularName() ?>);
  }
