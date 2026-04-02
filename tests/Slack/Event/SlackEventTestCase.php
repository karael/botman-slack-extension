<?php

declare(strict_types=1);

namespace Labdotgif\Tests\Slack\Event;

use Labdotgif\Slack\Event\SlackEventInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
abstract class SlackEventTestCase extends TestCase
{
    #[Test]
    public function getEventName(): void
    {
        $this->assertNotNull($this->getSlackEvent()->getEventName());
        $this->assertIsString($this->getSlackEvent()->getEventName());
    }

    abstract protected function getSlackEvent(): SlackEventInterface;
}
