<?php
namespace Core;
class Router{
	/**
	* Routing Table
	*/
	protected $routes = [];
	protected $params = [];
/************************************************************************/
	public function add($route, $params = []){
		// Convert the route ot regular expression: escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);
		// Convert variables e.g. {controller}
		$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
		// Convert variables with custome regular expression e.g. {id:\d+}
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>2)', $route);
		$route = '/^' . $route . '$/i';
		$this->routes[$route] = $params;
	}
/************************************************************************/
	public function getRoutes(){
		return $this->routes;
	}
/************************************************************************/
	public function match($url){
		foreach ($this->routes as $route => $params) {
			if(preg_match($route, $url, $matches)){
				foreach ($matches as $key => $match) {
					if(is_string($key)){
						$params[$key] = $match;
					}
				}
				$this->params = $params;
				return true;
			}
		}
		return false;
	}
/************************************************************************/
	public function getParams(){
		return $this->params;
	}
/************************************************************************/
	public function dispatch($url){
		$url = $this->removeQueryStringVariables($url);
		if($this->match($url)){
			// echo "$url";
			$controller = $this->params['controller'];
			$controller = $this->convertToPascalCase($controller);
			// $controller = "App/Controller//$controller";
			$controller = $this->getNamespace() . $controller;
			if(class_exists($controller)){
				$controller_object = new $controller($this->params);
				$action = $this->params['action'];
				$action = $this->convertToCamelCase($action);
				if(is_callable([$controller_object, $action])){
					$controller_object->$action();
				}else{
					echo "Method $action (in $controller) not found";
				}
			}else{
				echo "Controller class $controller not found";
				echo $controller;
			}
		}else{
			echo "No route matched $url";
		}
	}
/************************************************************************/
	protected function convertToPascalCase($string){
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
	}
/************************************************************************/
	protected function convertToCamelCase($string){
		return lcfirst($this->convertToPascalCase($string));
	}
/************************************************************************/
	protected function removeQueryStringVariables($url){
		if($url != ''){
			$parts = explode('&', $url, 2);
			if(strpos($parts[0], '=') === false){
				$url = $parts[0];
			}else{
				$url = '';
			}
		}
		return $url;
	}
/************************************************************************/
	protected function getNamespace(){
		$namespace = 'App\Controllers\\';
		if(array_key_exists($namespace, $this->params)){
			$namespace .= $this->params['namespace'] . '\\';
		}
		return $namespace;
	}
}