<?php

/**
 * Test for Slim Twig Flash.
 *
 * @link https://github.com/k-ko/slim-twig-flash for the canonical source repository
 *
 * @copyright Copyright (c) 2016 Vassilis Kanellopoulos <contact@kanellov.com>
 * @copyright Copyright (c) 2021 Knut Kohl <github@knutkohl.de>
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

namespace Tests;

use Twig\Environment;
use Twig\Extension\SlimFlashMessages;
use Twig\Loader\FilesystemLoader;

class TwigMessagesTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;

    protected $flash;

    protected $dummyMessages = [
        'key1' => [
            'my first message',
            'another message',
        ],
        'key2' => [
            'only one message',
        ],
    ];

    protected function setup()
    {
        $this->flash = $this->getMockBuilder('Slim\Flash\Messages')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'getMessages',
                'getMessage'
            ))
            ->getMock();
        $this->flash->expects($this->any())
            ->method('getMessages')
            ->willReturn($this->dummyMessages);
        $this->flash->expects($this->any())
            ->method('getMessage')
            ->will($this->returnCallback(function ($key) {
                return isset($this->dummyMessages[$key]) ? $this->dummyMessages[$key] : null;
            }));

        $this->extension = new SlimFlashMessages($this->flash);
        $this->view = new Environment(new FilesystemLoader(__DIR__ . '/templates'));
        $this->view->addExtension($this->extension);
    }

    public function testMessagesInTemplateUsingKey()
    {
        $result = $this->view->render('with-key.twig');
        $expected = implode("\n", $this->dummyMessages['key1']) . "\n";
        $this->assertEquals($expected, $result);
    }

    public function testMessagesInTemplateWithoutKey()
    {
        $result = $this->view->render('without-key.twig');
        $expected = 'key1: my first messagekey1: another messagekey2: only one message';

        $this->assertEquals($expected, $result);
    }
}
