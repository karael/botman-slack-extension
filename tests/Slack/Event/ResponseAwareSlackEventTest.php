<?php

declare(strict_types=1);

namespace Labdotgif\Tests\Slack\Event;

use Labdotgif\Slack\Event\ResponseAwareSlackEvent;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class ResponseAwareSlackEventTest extends TestCase
{
    #[Test]
    public function setResponse(): void
    {
        $event = $this->createEvent();

        $this->assertNull($event->getResponse());

        $response = new Response();
        $event->setResponse($response);

        $this->assertSame($response, $event->getResponse());
    }

    #[Test]
    public function getResponse(): void
    {
        $event = $this->createEvent();

        $this->assertNull($event->getResponse());

        $response = new Response();
        $event->setResponse($response);

        $this->assertEquals($response, $event->getResponse());
    }

    private function createEvent(): ResponseAwareSlackEvent
    {
        return new class extends ResponseAwareSlackEvent {
            public function getEventName(): string
            {
                return 'dummy';
            }
        };
    }
}
