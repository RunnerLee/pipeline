<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-12
 */

namespace Runner\Pipeline;

use Runner\Pipeline\Contracts\Pipeline as PipelineInterface;

class Pipeline implements PipelineInterface
{
    /**
     * @var array
     */
    protected $decorators = [];

    /**
     * @var mixed
     */
    protected $payload;

    /**
     * @var string
     */
    protected $method = 'handle';

    /**
     * @param string $payload
     *
     * @return $this
     */
    public function payload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param $decorator
     *
     * @return $this
     */
    public function pipe($decorator)
    {
        $this->decorators[] = $decorator;

        return $this;
    }

    /**
     * @param $method
     *
     * @return $this
     */
    public function method($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param null $callback
     *
     * @return mixed
     */
    public function process($callback = null)
    {
        $stage = array_reduce(
            array_reverse($this->decorators),
            $this->carry(),
            new Stage($this->prepareCallback($callback))
        );

        return $stage->handle($this->payload);
    }

    /**
     * @return \Closure
     */
    protected function carry()
    {
        return function ($stage, $decorator) {
            return new Stage(
                is_callable($decorator) ? $decorator : [$decorator, $this->method],
                $stage
            );
        };
    }

    /**
     * @param callable|null $callback
     *
     * @return callable
     */
    protected function prepareCallback($callback = null)
    {
        if (is_null($callback)) {
            $callback = function ($payload) {
                return $payload;
            };
        }

        return $callback;
    }
}
