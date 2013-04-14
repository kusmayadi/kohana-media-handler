<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Image extends Controller 
{
	public function action_index()
	{
		$width  = $this->request->param('width');
		$height = $this->request->param('height');
		$file   = $this->request->param('file');
		
		if ($width AND $height AND $file)
		{
			
			$upload_dir = realpath(Kohana::$config->load('mediahandler.upload_dir'));
			
			$file = $upload_dir . '/' . $file;
			
			$cache = Cache::instance(Kohana::$config->load('mediahandler.cache_engine'));
			
			$cache_key = $width.'x'.$height.'-'.str_replace('/', '-', $file);
			
			if ($image = $cache->get($cache_key, FALSE))
			{
				$this->response->headers('Content-Type', 'image/jpg');
				
				$this->response->body($image);
			} 
			elseif (file_exists($file))
			{
				$img = Image::factory($file);
				
				$this->response->headers('Content-Type', 'image/jpg');
				
				$image = $img->resize($width, $height, Image::AUTO)->render();
				
				$cache->set($cache_key, $image);
				
				$this->response->body($image);
			}
			else
			{
				throw new HTTP_Exception_404();
			}
			
		}
		else
		{
			throw new HTTP_Exception_403('Forbidden');
		}
		
	}
}