<?php

namespace ASF;

use Silex\Application;

class Language
{
	public $app;
	public $file;
	public $phrases = array();

	public function __construct (Application $app)
	{
		$this->app = $app;

		$this->file = __DIR__ . '/../../src/Languages/' . $this->app['defaults']['language'] . '.json';
		$this->phrases = json_decode(file_get_contents($this->file), true);
	}

	public function phrase ($phrase, $replacements = array())
	{
		if (array_key_exists($phrase, $this->phrases))
		{
			$phrase = nl2br($this->phrases[$phrase]);
		}

		if (count($replacements) > 0)
		{
			$phrase = vsprintf($phrase, $replacements);
		}

		return $phrase;
	}
}