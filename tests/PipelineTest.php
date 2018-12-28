<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-12
 */

use Runner\Pipeline\Pipeline;

class PipelineTest extends PHPUnit_Framework_TestCase
{

    public function testPipe()
    {

        $pipeline = new Pipeline();

        $pipeline->pipe(function ($payload, $next) {
            $this->assertSame($payload, 1);
            return $next($payload + 1);
        });

        $pipeline->pipe(function ($payload, $next) {
            $this->assertSame($payload, 2);
            return $next($payload + 2);
        });

        $pipeline->pipe(new class ($this) {

            protected $phpunit;

            public function __construct($phpunit)
            {
                $this->phpunit = $phpunit;
            }

            public function handle($payload, $next)
            {
                $this->phpunit->assertSame($payload, 4);
                return $next($payload + 10);
            }
        });

        $pipeline->payload(1)->method('handle')->process();
    }

}
