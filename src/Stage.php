<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-12
 */

namespace Runner\Pipeline;

use Runner\Pipeline\Contracts\Stage as StageInterface;

class Stage implements StageInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var Stage|null
     */
    protected $next;

    /**
     * Stage constructor.
     * @param $callback
     * @param Stage|null $next
     */
    public function __construct($callback, Stage $next = null)
    {
        $this->callback = $callback;
        $this->next = $next;
    }

    /**
     * @param $payload
     * @return mixed
     */
    public function handle($payload)
    {
        // destination callback (without next stage)
        if (is_null($this->next)) {
            return call_user_func($this->callback, $payload);
        }

        return call_user_func($this->callback, $payload, function ($payload) {
            return $this->next->handle($payload);
        });
    }
}