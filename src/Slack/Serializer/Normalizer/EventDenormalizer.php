<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Serializer\Normalizer;

use Labdotgif\Slack\Event\EventSlackEvent;
use Labdotgif\Slack\Event\SlackEventInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class EventDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return new EventSlackEvent($data['event']['type'], $data['event']['user']);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return
            SlackEventInterface::class === $type
            && 'json' === $format
            && isset($data['type'])
            && 'event_callback' === $data['type']
        ;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [SlackEventInterface::class => false];
    }
}
