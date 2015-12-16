<?php

namespace spec\Http\Client\Utils\MessageFactory;

use PhpSpec\ObjectBehavior;
use spec\Http\Client\Utils\MessageFactoryBehavior;

class GuzzleMessageFactorySpec extends ObjectBehavior
{
    use MessageFactoryBehavior;

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Client\Utils\MessageFactory\GuzzleMessageFactory');
    }
}
