<?php

namespace Aqilix\V1\Command;

use Aqilix\OAuth2\Entity\OauthClient as ClientEntity;
use Laminas\Crypt\Password\Bcrypt;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class GenerateOauthClient extends Command
{
    use LoggerAwareTrait;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthClient
     */
    protected $clientMapper;

    /**
     * @var \Laminas\Crypt\Password\PasswordInterface
     */
    protected $secretHasher;

    /**
     * @param  \Aqilix\OAuth2\Mapper\OauthClient  $clientMapper
     * @param  \Psr\Log\LoggerAwareInterface  $logger
     */
    public function __construct(
        $clientMapper,
        $logger
    ) {
        parent::__construct();

        $this->clientMapper = $clientMapper;
        $this->logger = $logger;

        $this->secretHasher = new Bcrypt();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('aqilix:v1:generate-oauth-client');
        $this->setDescription('Generate OAuth2 Client data.');
        $this->addArgument('clientId', InputArgument::REQUIRED, 'The client ID.');
        $this->addArgument('clientSecret', InputArgument::REQUIRED, 'The client Secret.');
        $this->addArgument('grantTypes', InputArgument::REQUIRED, 'The client grant types. '
            . 'Common grant types are: password, refresh-token, & authorization-code.');
        $this->addArgument('redirectUri', InputArgument::OPTIONAL, 'The redirect URI.', null);
        $this->addArgument('scope', InputArgument::OPTIONAL, 'The client scope.', null);
        $this->addArgument('userId', InputArgument::OPTIONAL, 'The client user ID.', null);
    }

    /**
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function execute($input, $output)
    {
        try {
            $clientId = $input->getArgument('clientId');
            $clientSecret = $input->getArgument('clientSecret');
            $grantTypes = $input->getArgument('grantTypes');
            $redirectUri = $input->getArgument('redirectUri');
            $scope = $input->getArgument('scope');
            $userId = $input->getArgument('userId');

            $client = new ClientEntity();
            $client->setClientId($clientId);
            $client->setClientSecret($this->secretHasher->create($clientSecret));
            $client->setGrantTypes($grantTypes);
            $client->setRedirectUri($redirectUri);
            $client->setScope($scope);
            $client->setUserId($userId);

            $this->clientMapper->save($client);

            $this->logger->log(
                \Psr\Log\LogLevel::DEBUG,
                "{function} {clientId}",
                [
                    "function"  => __FUNCTION__,
                    "clientId"  => $clientId,
                ]
            );

            $output->writeln('<info>Generated oauth client for clientId: ' . $clientId . '</info>');
            return self::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln('<error>Error: ' . $ex->getMessage() . '</error>');
            return self::FAILURE;
        }
    }
}
