<?php

namespace Controller;

class HomeController extends Controller
{
	public $login_required = false;
	
	public function __construct(\Silex\Application $app)
	{
		$this->app = $app;
		$this->init();
	}

	public function index()
	{
		$forums = $this->app['forum']->findAll();

		return $this->app['twig']->render('Home/index.twig', array(
			'title' 			=> 'Home',
			'section'			=> 'index',
			'forums' 			=> $forums
		) + $this->extras);
	}
}