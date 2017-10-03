## Usage

You can use `EmailShell` to test your email configurations in any environment and ensure everything is working. You can even add it as part of your deployment process to certify email sending is working as expected.

To see command overview and subcommands you can execute:

```
bin/cake email
```

### Subcommand: *send*

You can display command help using:

```
bin/cake email send --help
```

There are several optional parameters:

* **config**: The email configuration you want to test. *default: default*
* **subject**: You can customize test email subject. *default: Test email* 
* **message**: You can customize test email message. *default: This is a test email* 
* **quite**: If set, it does not display email headers and message on success and it does not display exception message on failure.
* **verbose**: Not used at this moment.
* **help**: If set, it displays the command help.

There are also one required argument:

* **email**: The recipient the email will be sent to.

An example call with all default values:

```
bin/cake email send contact@cakedc.com
```

It will send an email with `Test email` subject and `This is a test email` as message body to `contact@cakedc.com` using the `default` email configuration. You will get an output like this:

```
Welcome to CakePHP v3.5.3 Console
---------------------------------------------------------------
Email config : default
Email recipient: contact@cakedc.com
---------------------------------------------------------------
Email message sent successfully

Headers
From: test@cakedc.com
Date: Tue, 03 Oct 2017 11:40:53 +0000
Message-ID: <21170bbf52264c7dba99b5b7aef08806@cakedc.com>
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit

Message
This is a test email
```