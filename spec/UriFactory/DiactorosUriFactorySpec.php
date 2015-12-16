<?php

namespace spec\Http\Client\Utils\UriFactory;

use Psr\Http\Message\UriInterface;
use PhpSpec\ObjectBehavior;
use spec\Http\Client\Utils\UriFactoryBehavior;

class DiactorosUriFactorySpec extends ObjectBehavior
{
    use UriFactoryBehavior;

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Client\Utils\UriFactory\DiactorosUriFactory');
    }

    /**
     * TODO: Remove this when https://github.com/phpspec/phpspec/issues/825 is resolved
     */
    function it_creates_a_uri_from_uri(UriInterface $uri)
    {
        $this->createUri($uri)->shouldReturn($uri);
    }
}
