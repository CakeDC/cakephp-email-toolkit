<?php
namespace CakeDC\EmailToolkit\Test\TestCase\Shell;

use Cake\TestSuite\TestCase;
use Cake\Utility\Hash;

/**
 * CakeDC\EmailToolkit\Shell\EmailShell Test Case
 */
class EmailShellTest extends TestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \CakeDC\EmailToolkit\Shell\EmailShell
     */
    public $EmailShell;

    /**
     * Email instance
     *
     * @var \Cake\Mailer\Email
     */
    public $Email;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->EmailShell = $this->getMockBuilder('CakeDC\EmailToolkit\Shell\EmailShell')->setConstructorArgs([$this->io])->setMethods(['_getEmailInstance'])->getMock();
        $this->Email = $this->getMockBuilder('Cake\Mailer\Email')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailShell);

        parent::tearDown();
    }

    /**
     * Test send method
     *
     * @return void
     */
    public function testSend()
    {
        $this->Email->expects($this->once())
            ->method('setProfile')
            ->with('test')
            ->will($this->returnValue($this->Email));
        $this->Email->expects($this->once())
            ->method('setSubject')
            ->with('test subject')
            ->will($this->returnValue($this->Email));
        $this->Email->expects($this->once())
            ->method('addTo')
            ->with('test@email.com')
            ->will($this->returnValue($this->Email));
        $this->Email->expects($this->once())
            ->method('send')
            ->with('test message')
            ->will($this->returnValue(['headers' => 'email headers', 'message' => 'test message']));
        $this->EmailShell->expects($this->once())
            ->method('_getEmailInstance')
            ->will($this->returnValue($this->Email));

        $this->EmailShell->params = [
            'config' => 'test',
            'subject' => 'test subject',
            'message' => 'test message'
        ];
        $this->EmailShell->args = ['test@email.com'];
        $this->EmailShell->initialize();
        $this->EmailShell->startup();
        $result = $this->EmailShell->send();
        $this->assertEquals(0, $result);
    }

    /**
     * Test send method
     *
     * @return void
     */
    public function testSendException()
    {
        $this->Email->expects($this->once())
            ->method('setProfile')
            ->with('test')
            ->will($this->throwException(new \Exception()));
        $this->EmailShell->expects($this->once())
            ->method('_getEmailInstance')
            ->will($this->returnValue($this->Email));

        $this->EmailShell->params = [
            'config' => 'test',
            'subject' => 'test subject',
            'message' => 'test message'
        ];
        $this->EmailShell->args = ['test@email.com'];

        $this->EmailShell->initialize();
        $this->EmailShell->startup();
        $result = $this->EmailShell->send();
        $this->assertEquals(1, $result);
    }

    /**
     * Test getOptionParser method
     *
     * @return void
     */
    public function testGetOptionParser()
    {
        $subcommands = $this->EmailShell->getOptionParser()->subcommands();
        $this->assertEquals(1, count($subcommands));
        /** @var \Cake\Console\ConsoleInputSubcommand $sendSubcommand */
        $sendSubcommand = Hash::get($subcommands, 'send');
        $arguments = $sendSubcommand->parser()->arguments();
        $options = $sendSubcommand->parser()->options();
        $this->assertEquals(1, count($arguments));
        $this->assertEquals(6, count($options));
        $this->assertNotEmpty(Hash::get($options, 'subject'));
        $this->assertNotEmpty(Hash::get($options, 'message'));
        $this->assertNotEmpty(Hash::get($options, 'config'));
    }
}
