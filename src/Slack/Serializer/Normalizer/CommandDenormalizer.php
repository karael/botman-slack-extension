<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Serializer\Normalizer;

use Labdotgif\Slack\Event\CommandSlackEvent;
use Labdotgif\Slack\Event\SlackEventInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class CommandDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return new CommandSlackEvent(
            $data['channel_id'],
            $data['user_id'],
            $data['command'],
            trim($data['text']),
            $data['response_url']
        );
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return
            SlackEventInterface::class === $type
            && 'json' === $format
            && isset($data['command'])
            && isset($data['response_url'])
        ;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [SlackEventInterface::class => false];
    }
}
