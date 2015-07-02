<?php

class Flickr
{
	private $api;
	private $page;
	private $pages;
	private $default = [
				'method' => 'photos',
				'user' => '47690304@N02',
				'photoset' => '72157645040997172',
				'perpage' => 10,
				'size' => '_z'
			];


	public function __construct($api)
	{
		$this->api = $api;
		$this->page = isset($_GET['p']) ? $_GET['p'] : 1;
	}

	public function getPhotos($option = [])
	{
		$setting = (object) array_merge($this->default, $option);

		$data = $this->getJson($setting);
		$this->buildImages($data, $setting);
		$this->getInfo($data, $setting->method);
		$this->setPages($data->{$setting->method}->pages);
		return $this;
	}

	private function getJson($setting)
	{
		$services = 'https://api.flickr.com/services/rest/?method=';
		$format = '&format=json&nojsoncallback=1';

		switch ($setting->method)
		{
			case 'photos':
				$resp = $services.'flickr.people.getPhotos&api_key='.$this->api.'&user_id='.$setting->user.'&per_page='.$setting->perpage.'&page='.$this->page.$format;
				break;
			case 'photoset':
				$resp = $services.'flickr.photosets.getPhotos&api_key='.$this->api.'&photoset_id='.$setting->photoset.'&user_id='.$setting->user.'&per_page='.$setting->perpage.'&page='.$this->page.$format;
				break;
			default:
				exit('invalid method');
				break;
		}

		$json = @file_get_contents($resp);
		$data = json_decode($json);
		if ($data->stat == 'fail') header('location: flickr.php');

		return $data;
	}

	private function buildImages($data, $setting)
	{
		echo '<div id="img">';
		foreach ($data->{$setting->method}->photo as $data)
		{
			echo '<a><img src="https://farm'.$data->farm.'.staticflickr.com/'.$data->server.'/'.$data->id.'_'.$data->secret.$setting->size.'.jpg"></a>';
		}
		echo '</div>';
	}

	private function getInfo($data, $method)
	{
		echo '<p> per page: <b>'.$data->{$method}->perpage.'</b>';
		echo ' | total pages: <b>'.$data->{$method}->pages.'</b>';
		echo ' | total photos: <b>'.$data->{$method}->total.'</b></p>';
	}

	private function setPages($data)
	{
		$this->pages = $data;
	}

	public function getPages()
	{
		return $this->pages;
	}

	public function render(Pagination $p)
	{
		$p->bootstrapPagination();
	}
}
?>

