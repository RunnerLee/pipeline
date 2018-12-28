<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-12
 */

namespace Runner\Pipeline\Contracts;

interface Pipeline
{
    public function pipe($decorator);

    public function process($payload);
}
