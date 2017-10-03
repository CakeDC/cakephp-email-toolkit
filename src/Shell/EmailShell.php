<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace CakeDC\EmailToolkit\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Utility\Hash;

/**
 * Email shell command.
 */
class EmailShell extends Shell
{

    /**
     * email config
     *
     * @var string
     */
    protected $_config;

    /**
     * subject
     *
     * @var string
     */
    protected $_subject;

    /**
     * message
     *
     * @var string
     */
    protected $_message;

    /**
     * email address
     *
     * @var string
     */
    protected $_email;

    /**
     * Override initialize of the Shell
     *
     * @return void
     */
    public function initialize()
    {
        $this->_config = 'default';
        $this->_subject = __('Test email');
        $this->_message = __('This is a test email');
    }

    /**
     * Starts up the Shell and displays the welcome message.
     * Allows for checking and configuring prior to command or main execution
     *
     * Override this method if you want to remove the welcome information,
     * or otherwise modify the pre-command flow.
     *
     * @return void
     * @link https://book.cakephp.org/3.0/en/console-and-shells.html#hook-methods
     */
    public function startup()
    {
        if (!empty($this->params['config'])) {
            $this->_config = $this->params['config'];
        }

        if (!empty($this->params['subject'])) {
            $this->_subject = $this->params['subject'];
        }

        if (!empty($this->params['message'])) {
            $this->_message = $this->params['message'];
        }
        if (!empty($this->args[0])) {
            $this->_email = $this->args[0];
        }

        parent::startup();
    }

    /**
     * Displays a header for the shell
     *
     * @return void
     */
    protected function _welcome()
    {
        $this->out();
        $this->out(sprintf('<info>Welcome to CakePHP %s Console</info>', 'v' . Configure::version()));
        $this->hr();
        $this->out(sprintf('Email config : %s', $this->_config));
        $this->out(sprintf('Email recipient: %s', $this->_email));
        $this->hr();
    }

    /**
     * Send method
     */
    public function send()
    {
        try {
            $email = $this->_getEmailInstance();
            $result = $email->setProfile($this->_config)
                ->setSubject($this->_subject)
                ->addTo($this->_email)
                ->send($this->_message);
            if (empty($this->params['quiet']) && !empty($result['headers'])) {
                $this->success('Email message sent successfully');
                $this->out('');
                $this->info('Headers');
                $this->out(Hash::get($result, 'headers'));
                $this->out('');
                $this->info('Message');
                $this->out(Hash::get($result, 'message'));
            }

            return 0;
        } catch (\Exception $e) {
            if (empty($this->params['quiet'])) {
                $this->err(sprintf('Error: %s', $e->getMessage()));
                if (method_exists($email->getTransport(), 'getLastResponse')) {
                    $response = $email->getTransport()->getLastResponse();
                    $this->out('');
                    $this->info('Response');
                    $this->out('');
                    $this->out(sprintf('<info>Code:</info> %s', Hash::get($response, '0.code')));
                    $this->out(sprintf('<info>Message:</info> %s', Hash::get($response, '0.message')));
                }
            }

            return 1;
        }
    }

    /**
     * @return Email
     */
    protected function _getEmailInstance()
    {
        return new Email();
    }

    /**
     * Gets the option parser instance and configures it.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        $sendParser = parent::getOptionParser();
        $parser->setDescription([
            'PHP Email Testing for CakePHP',
        ])->addSubcommand('send', [
            'help' => 'Send test email.',
            'parser' => $sendParser
                ->addArgument('email', [
                    'required' => true,
                    'help' => 'Email Recipient'
                ])->addOption('config', [
                    'short' => 'c',
                    'help' => 'Email Config',
                    'choices' => Email::configured()
                ])->addOption('subject', [
                    'short' => 's',
                    'help' => 'Email Subject'
                ])->addOption('message', [
                    'short' => 'm',
                    'help' => 'Email Content'
                ])
        ]);

        return $parser;
    }
}
