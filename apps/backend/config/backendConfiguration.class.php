<?php

class backendConfiguration extends sfApplicationConfiguration
{
    public function configure()
    {
    }
    protected $enrutamientoFrontend = null;

    public function generaUrlFrontend($nombre, $parametros = array())
    {
        return 'http://grupoagrupo.net'.$this-> getEnrutamientoFrontend()->generate($nombre, $parametros);
    }

    public function getEnrutamientoFrontend()
    {
        if (!$this->enrutamientoFrontend)
        {
            $this->enrutamientoFrontend= new sfPatternRouting(new sfEventDispatcher());

            $configuracion = new sfRoutingConfigHandler();
            $rutas = $configuracion->evaluate(array(sfConfig::get('sf_apps_dir').'/frontend/config/routing.yml'));
            $this->enrutamientoFrontend->setRoutes($rutas);
        }

        return $this->enrutamientoFrontend;
    }
}
