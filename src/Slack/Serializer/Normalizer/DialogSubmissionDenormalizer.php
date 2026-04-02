<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Serializer\Normalizer;

use Labdotgif\Slack\Event\DialogSubmissionSlackEvent;
use Labdotgif\Slack\Event\SlackEventInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class DialogSubmissionDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return new DialogSubmissionSlackEvent(
            $data['channel']['id'],
            $data['user']['id'],
            $data['submission'],
            $data['state'],
            $data['callback_id'],
            $data['response_url']
        );
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return
            SlackEventInterface::class === $type
            && 'json' === $format
            && isset($data['type'])
            && 'dialog_submission' === $data['type']
        ;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [SlackEventInterface::class => false];
    }
}
