<?php

namespace spec\Http\Utils\MessageFactory;

use PhpSpec\ObjectBehavior;
use spec\Http\Utils\MessageFactoryBehavior;

class GuzzleMessageFactorySpec extends ObjectBehavior
{
    use MessageFactoryBehavior;

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Utils\MessageFactory\GuzzleMessageFactory');
    }
}
