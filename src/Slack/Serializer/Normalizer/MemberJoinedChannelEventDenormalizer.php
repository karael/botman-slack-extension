<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Serializer\Normalizer;

use Labdotgif\Slack\Event\MemberJoinedChannelEventSlackEvent;
use Labdotgif\Slack\Event\SlackEvents;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class MemberJoinedChannelEventDenormalizer extends EventDenormalizer
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return new MemberJoinedChannelEventSlackEvent(
            $data['event']['type'],
            $data['event']['user'],
            $data['event']['channel']
        );
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if (!parent::supportsDenormalization($data, $type, $format)) {
            return false;
        }

        return SlackEvents::MEMBER_JOINED_CHANNEL === $data['event']['type'];
    }
}
