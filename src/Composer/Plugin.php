<?php
namespace Bmack\ComposerProjectContext\Composer;
/*
 * Copyright notice.
 *
 * (c) Benni Mack <benjamin.mack@gmail.com>
 * All Rights Reserved.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;

/**
 * Main entrypoint to be run when composer is activated.
 *
 * Basically detects the projects' root and exposes this in
 * vendor/autoload.php to be used within
 */
class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_AUTOLOAD_DUMP => 'addProjectRootToAutoloader',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        // does nothing for activation
    }

    /**
     * Fetches the project root and writes it to the autoloader file.
     *
     * @param \Composer\Script\Event $event
     */
    public function addProjectRootToAutoloader(\Composer\Script\Event $event) {
        $composerConfig = $event->getComposer()->getConfig();
        $vendorDir = $composerConfig->get('vendor-dir');
        $autoloadFile = $vendorDir . '/autoload.php';
        if (!file_exists($autoloadFile)) {
            throw new \RuntimeException(sprintf(
                'Could not adjust autoloader: The file %s was not found.',
                $autoloadFile
            ));
        }

        $event->getIO()->write('<info>Inserting BMACK_PROJECTROOT constant</info>');
        $contents = file_get_contents($autoloadFile);
        $constant = "if (!defined('BMACK_PROJECTROOT')) {\n";
        $constant .= "	define('BMACK_PROJECTROOT', '" . getcwd() . "'');\n";
        $constant .= "}\n\n";
        // Regex modifiers:
        // "m": \s matches newlines
        // "D": $ matches at EOF only
        // Translation: insert before the last "return" in the file
        $contents = preg_replace('/\n(?=return [^;]+;\s*$)/mD', "\n" . $constant, $contents);
        file_put_contents($autoloadFile, $contents);
    }
}