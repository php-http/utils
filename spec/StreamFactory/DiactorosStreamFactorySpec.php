<?php

namespace spec\Http\Utils\StreamFactory;

use Zend\Diactoros\Stream;
use PhpSpec\ObjectBehavior;
use spec\Http\Utils\StreamFactoryBehavior;

class DiactorosStreamFactorySpec extends ObjectBehavior
{
    use StreamFactoryBehavior;

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Utils\StreamFactory\DiactorosStreamFactory');
    }

    function it_creates_a_stream_from_stream()
    {
        $this->createStream(new Stream('php://memory'))
            ->shouldHaveType('Psr\Http\Message\StreamInterface');
    }
}
