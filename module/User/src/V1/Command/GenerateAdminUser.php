<?php

namespace User\V1\Command;

use Aqilix\OAuth2\Entity\OauthUser as UserEntity;
use Laminas\Crypt\Password\Bcrypt;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use User\Entity\UserProfile as UserProfileEntity;

class GenerateAdminUser extends Command
{
    use LoggerAwareTrait;

    /**
     * @var \User\Mapper\UserProfile
     */
    protected $userProfileMapper;

    /**
     * @var \Aqilix\OAuth2\Mapper\OauthUser
     */
    protected $userMapper;

    /**
     * @var \Laminas\Crypt\Password\PasswordInterface
     */
    protected $secretHasher;

    /**
     * @param  \User\Mapper\UserProfile  $userProfileMapper
     * @param  \Aqilix\OAuth2\Mapper\OauthUser  $userMapper
     * @param  \Psr\Log\LoggerAwareInterface  $logger
     */
    public function __construct(
        $userProfileMapper,
        $userMapper,
        $logger
    ) {
        parent::__construct();

        $this->userProfileMapper = $userProfileMapper;
        $this->userMapper = $userMapper;
        $this->logger = $logger;

        $this->secretHasher = new Bcrypt();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('user:v1:generate-admin-user');
        $this->setDescription('Generate admin user data (including OAuth2 User).');
        $this->addArgument('password', InputArgument::REQUIRED, 'The password for admin user.');
    }

    /**
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function execute($input, $output)
    {
        try {
            if ($this->isAdminUserAlreadyExists()) {
                $output->writeln('<info>Admin user alredy exists.</info>');
                return self::SUCCESS;
            }

            $password = $input->getArgument('password');

            $user = new UserEntity();
            $user->setFirstName('Admin');
            $user->setLastName('Admin');
            $user->setUsername('admin');
            $user->setPassword($this->secretHasher->create($password));

            $userProfile = new UserProfileEntity();
            $userProfile->setFirstName('Admin');
            $userProfile->setLastName('Admin');
            $userProfile->setIsActive(true);
            $userProfile->setUser($user);

            $this->userProfileMapper
                ->getEntityManager()
                ->persist($user);
            $this->userProfileMapper
                ->save($userProfile);

            $this->logger->log(
                \Psr\Log\LogLevel::DEBUG,
                "{function} {username}",
                [
                    "function"  => __FUNCTION__,
                    "username"  => $userProfile->getUser()->getUsername(),
                ]
            );

            $output->writeln('<info>Generated admin user.</info>');
            return self::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln('<error>Error: ' . $ex->getMessage() . '</error>');
            return self::FAILURE;
        }
    }

    /**
     * @return bool
     */
    protected function isAdminUserAlreadyExists()
    {
        $adminUser = $this->userProfileMapper
            ->fetchOneByOauthUsername('admin');

        return $adminUser !== null;
    }
}
