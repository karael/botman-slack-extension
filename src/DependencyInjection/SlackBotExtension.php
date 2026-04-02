<?php

declare(strict_types=1);

namespace Labdotgif\DependencyInjection;

use Labdotgif\Slack\Bot\BotFactory;
use Labdotgif\Slack\Serializer\Normalizer\VerificationUrlDenormalizer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SlackBotExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @var string
     */
    private $oauthToken;

    /**
     * @var string
     */
    private $botOauthToken;

    /**
     * @var string
     */
    private $verificationUrlToken;

    public function __construct(string $oauthToken, string $botOauthToken, string $verificationUrlToken)
    {
        $this->oauthToken           = $oauthToken;
        $this->botOauthToken        = $botOauthToken;
        $this->verificationUrlToken = $verificationUrlToken;
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('bot.yaml');
        $loader->load('normalizers.yaml');
        $loader->load('subscribers.yaml');

        $container->getDefinition(BotFactory::class)
            ->setArgument('$oauthToken', $configs[0]['slack.oauth.token'])
            ->setArgument('$botOauthToken', $configs[0]['slack.bot.oauth.token']);

        $container->getDefinition(VerificationUrlDenormalizer::class)
            ->setArgument('$slackVerificationToken', $configs[0]['slack.verification_url.token']);
    }

    public function prepend(ContainerBuilder $container): void
    {
        // FIXME Should be in a configuration node, but it's time saving
        $container->prependExtensionConfig('slack_bot', [
            'slack.oauth.token'            => $this->oauthToken,
            'slack.bot.oauth.token'        => $this->botOauthToken,
            'slack.verification_url.token' => $this->verificationUrlToken,
        ]);
    }
}
