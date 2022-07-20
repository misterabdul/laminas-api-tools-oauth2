<?php

namespace User\V1\Command;

use Laminas\View\Model\ViewModel;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Part as MimePart;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class SendResetPasswordEmail extends Command
{
    use LoggerAwareTrait;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Laminas\Mail\Transport\TransportInterface
     */
    protected $mailTransport;

    /**
     * @var \Laminas\Mail\Message
     */
    protected $resetPasswordMailMessage;

    /**
     * @var \Laminas\View\Renderer\RendererInterface;
     */
    protected $viewRenderer;

    /**
     * @param  array  $config
     * @param  \Laminas\Mail\Transport\TransportInterface  $mailTransport
     * @param  \Laminas\Mail\Message  $resetPasswordMailMessage
     * @param  \Laminas\View\Renderer\RendererInterface  $viewRenderer
     */
    public function __construct(
        $config,
        $mailTransport,
        $resetPasswordMailMessage,
        $viewRenderer,
        $logger
    ) {
        parent::__construct();

        $this->config = $config;
        $this->mailTransport = $mailTransport;
        $this->resetPasswordMailMessage = $resetPasswordMailMessage;
        $this->viewRenderer = $viewRenderer;
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('user:send-resetpassword-email');
        $this->setDescription('Send Reset Password Link to Email');
        $this->addArgument('emailAddress', InputArgument::REQUIRED, 'Email Address of New User');
        $this->addArgument('resetPasswordKey', InputArgument::REQUIRED, 'Reset Password Key');
    }

    /**
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function execute($input, $output)
    {
        try {
            $emailAddress = $input->getArgument('emailAddress');
            $resetPasswordKey = $input->getArgument('resetPasswordKey');

            $view = new ViewModel([
                'contactUsUrl' => $this->config['contact_us'],
                'resetPasswordUrl' => str_replace(':code', $resetPasswordKey, $this->config['reset_password_url']),
            ]);
            $view->setTemplate('user/email/resetpassword.phtml');
            $html = $this->viewRenderer->render($view);

            $htmlMimePart = new MimePart($html);
            $htmlMimePart->setType('text/html');
            $mimeMessage  = new MimeMessage();
            $mimeMessage->addPart($htmlMimePart);

            $mailMessage = $this->resetPasswordMailMessage
                ->addTo($emailAddress)
                ->setBody($mimeMessage);

            $this->mailTransport->send($mailMessage);

            $this->logger->log(
                \Psr\Log\LogLevel::DEBUG,
                "{function} {emailAddress}",
                [
                    "function" => __FUNCTION__,
                    "emailAddress" => $emailAddress,
                ]
            );

            return self::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln('<error>Error: ' . $ex->getMessage() . '</error>');
            return self::FAILURE;
        }
    }
}
