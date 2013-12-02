<?php

require_once '/var/lib/symfony/autoload/sfCoreAutoload.class.php'; 

sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
    public function setup()
    {
        $this->enablePlugins('sfDoctrinePlugin');
        $this->enablePlugins('csDoctrineActAsSortablePlugin');
        $this->enablePlugins('sfJQueryUIPlugin');
        $this->enablePlugins('sfFormExtraPlugin');
        $this->enablePlugins('sfDependentSelectPlugin');
        $this->enablePlugins('sfContactFormPlugin');
        $this->enablePlugins('sfDoctrineGuardPlugin');
        $this->enablePlugins('sfThumbnailPlugin');
        $this->enablePlugins('ajDoctrineLuceneablePlugin');
        $this->enablePlugins('sfJqueryReloadedPlugin');
        $this->enablePlugins('sfDoctrineApplyPlugin');
        $this->enablePlugins('sfDoctrineSimpleForumPlugin');
        $this->enablePlugins('sfWhoIsOnlinePlugin');

        //set_include_path(sfConfig::get('sf_lib_dir') . '/vendor' . PATH_SEPARATOR . get_include_path());

        sfConfig::add(array(
  			'sf_upload_dir_name'  => $sf_upload_dir_name = 'images/uploads',
  			'sf_upload_dir'       => sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$sf_upload_dir_name,      
        ));
        sfConfig::set('sf_images_dir', sfConfig::get('sf_web_dir').'/images/uploads');
        sfConfig::set('sf_viewsize_dir', sfConfig::get('sf_upload_dir').'/view_size');

        sfConfig::set('sf_thumbnail_dir', sfConfig::get('sf_upload_dir').'/thumbnails');

        sfConfig::set('sf_product_dir', sfConfig::get('sf_upload_dir').'/product');
        sfConfig::set('sf_product_thumbnail_dir', sfConfig::get('sf_product_dir').'/thumbnails');

        sfConfig::set('sf_documents_dir', sfConfig::get('sf_upload_dir').'/documents');
        sfConfig::set('sf_documents_images_dir', sfConfig::get('sf_documents_dir').'/images');
        sfConfig::set('sf_documents_thumbnail_dir', sfConfig::get('sf_documents_dir').'/thumbnails');

        sfConfig::set('sf_provider_dir', sfConfig::get('sf_upload_dir').'/provider');
        sfConfig::set('sf_provider_thumbnail_dir', sfConfig::get('sf_provider_dir').'/thumbnails');

      $this->enablePlugins('sfSimpleGoogleSitemapPlugin');
    $this->enablePlugins('sfTCPDFPlugin');
  }
}
