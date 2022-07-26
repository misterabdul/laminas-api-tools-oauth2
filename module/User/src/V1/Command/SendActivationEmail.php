<?php

namespace User\V1\Command;

use Laminas\View\Model\ViewModel;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Part as MimePart;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class SendActivationEmail extends Command
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
    protected $activationMailMessage;

    /**
     * @var \Laminas\View\Renderer\RendererInterface;
     */
    protected $viewRenderer;

    /**
     * @param  array  $config
     * @param  \Laminas\Mail\Transport\TransportInterface  $mailTransport
     * @param  \Laminas\Mail\Message  $activationMailMessage
     * @param  \Laminas\View\Renderer\RendererInterface  $viewRenderer
     * @param  \Psr\Log\LoggerAwareInterface  $logger
     */
    public function __construct(
        $config,
        $mailTransport,
        $activationMailMessage,
        $viewRenderer,
        $logger
    ) {
        parent::__construct();

        $this->config = $config;
        $this->mailTransport = $mailTransport;
        $this->activationMailMessage = $activationMailMessage;
        $this->viewRenderer = $viewRenderer;
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('user:v1:send-activation-email');
        $this->setDescription('Send Notification Account Activated to New User');
        $this->addArgument('emailAddress', InputArgument::REQUIRED, 'Email Address of New User');
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

            $view = new ViewModel(['contactUsUrl' => $this->config['contact_us']]);
            $view->setTemplate('user/email/activation.phtml');
            $html = $this->viewRenderer->render($view);

            $htmlMimePart = new MimePart($html);
            $htmlMimePart->setType('text/html');
            $mimeMessage = new MimeMessage();
            $mimeMessage->addPart($htmlMimePart);

            $mailMessage = $this->activationMailMessage
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
