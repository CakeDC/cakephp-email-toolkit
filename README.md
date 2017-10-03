
CakeDC Email Toolkit plugin for CakePHP
=======================================

[![Bake Status](https://secure.travis-ci.org/CakeDC/cakephp-email-toolkit.png?branch=master)](http://travis-ci.org/CakeDC/cakephp-email-toolkit)
[![Downloads](https://poser.pugx.org/CakeDC/cakephp-email-toolkit/d/total.png)](https://packagist.org/packages/CakeDC/cakephp-email-toolkit)
[![Latest Version](https://poser.pugx.org/CakeDC/cakephp-email-toolkit/v/stable.png)](https://packagist.org/packages/CakeDC/cakephp-email-toolkit)
[![License](https://poser.pugx.org/CakeDC/cakephp-email-toolkit/license.svg)](https://packagist.org/packages/CakeDC/cakephp-email-toolkit)

Requirements
------------

* CakePHP 3.1.0+
* PHP 5.6+

Documentation
-------------

For documentation, as well as tutorials, see the [Docs](Docs/Home.md) directory of this repository.

Usage Example
-------------

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

Support
-------

For bugs and feature requests, please use the [issues](https://github.com/CakeDC/cakephp-email-toolkit/issues) section of this repository.

Commercial support is also available, [contact us](https://www.cakedc.com/contact) for more information.

Contributing
------------

This repository follows the [CakeDC Plugin Standard](https://www.cakedc.com/plugin-standard). If you'd like to contribute new features, enhancements or bug fixes to the plugin, please read our [Contribution Guidelines](https://www.cakedc.com/contribution-guidelines) for detailed instructions.

License
-------

Copyright 2017 Cake Development Corporation (CakeDC). All rights reserved.

Licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.