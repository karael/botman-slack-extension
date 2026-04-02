<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Serializer\Normalizer;

use Labdotgif\Slack\Event\ButtonActionSlackEvent;
use Labdotgif\Slack\Event\SlackEventInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class ButtonActionDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return new ButtonActionSlackEvent(
            $data['actions'][0]['name'],
            $data['actions'][0]['value'],
            $data['callback_id'],
            $data['channel']['id'],
            $data['user']['id'],
            (int) $data['attachment_id'],
            (float) $data['message_ts'],
            $data['response_url'],
            $data['original_message'] ?? null
        );
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return
            SlackEventInterface::class === $type
            && 'json' === $format
            && isset($data['type'])
            && 'interactive_message' === $data['type']
            && isset($data['actions'][0]['type'])
            && 'button' === $data['actions'][0]['type']
        ;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [SlackEventInterface::class => false];
    }
}
