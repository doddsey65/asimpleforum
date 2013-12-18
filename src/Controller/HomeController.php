<?php

namespace Controller;

class HomeController
{
	public $app;

	public function index()
	{
		$forums = $this->app['forum']->find_all();

		var_dump($forums);

		return $this->app['twig']->render('Home/index.twig', array(
			'title' 			=> 'Home',
			'section'			=> 'index',
			'forums' 			=> $forums
		));
	}
}