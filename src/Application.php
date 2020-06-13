<?php
declare(strict_types=1);

namespace SONFin;

use SONFin\Plugins\PluginInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\Response\RedirectResponse;

class Application
{
    private $_serviceContainer;
    private $_befores = [];

    public function __construct(ServiceContainerInterface $_serviceContainer)
    {
        $this->_serviceContainer = $_serviceContainer;
    }

    public function service($name)
    {
        return $this->_serviceContainer->get($name);
    }

    public function addService(string $name, $service): void
    {
        if (is_callable($service)) {
            $this->_serviceContainer->addLazy($name, $service);
        } else {
            $this->_serviceContainer->add($name, $service);
        }
    }

    public function plugin(PluginInterface $plugin): void
    {
        $plugin->register($this->_serviceContainer);
    }

    public function get($path, $action, $name = null)
    {
        $routing = $this->service('routing');
        $routing->get($name, $path, $action);
        return $this;
    }
    public function post($path, $action, $name = null)
    {
        $routing = $this->service('routing');
        $routing->post($name, $path, $action);
        return $this;
    }

    public function redirect($path)
    {
        return new RedirectResponse($path);
    }

    public function route(string $name, array $params = [])
    {
        $generator = $this->service('routing.generator');
        $path = $generator->generate($name, $params);
        return $this->redirect($path);       
    }

    public function before(callable $callback)
    {
        array_push($this->_befores, $callback);
        return $this;
    }

    protected function runBefores()
    {
        foreach ($this->_befores as $callback) {
            $result = $callback($this->service(RequestInterface::class));
            if ($result instanceof ResponseInterface) {
                return $result;
            }
        }
        return null;
    }

    public function start()
    {
        $route = $this->service('route');
        // Request interface para a variável request
        $request = $this->service(RequestInterface::class);

        if (!$route) {
            echo "Page not found";
            exit;
        }

        foreach ($route->attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        $result = $this->runBefores();
        if ($result) {
            $this->emitResponse($result);
            return;
        }

        $callable = $route->handler;
        $response = $callable($request);
        $this->emitResponse($response);
    }

    protected function emitResponse(ResponseInterface $response)
    {
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }

    // Lógica - Função -> resposta ou redirecionamento ( controle de rotas/ middleware )
    
}
