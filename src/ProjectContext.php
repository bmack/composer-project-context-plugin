<?php
namespace Bmack\ComposerProjectContext;
/*
 * Copyright notice.
 *
 * (c) Benni Mack <benjamin.mack@gmail.com>
 * All Rights Reserved.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/**
 * Class ProjectContext,
 * typically instantiated like this
 * $context = new ProjectContext(BMACK_PROJECTROOT);
 */
class ProjectContext
{
    /**
     * The path holding the root directory
     * @var
     */
    protected $rootDirectory;

    /**
     * The location to the configuration file
     * @var string
     */
    protected $configurationFile;

    /**
     * The constructor to set the root directory.
     *
     * @param $rootDirectory
     * @param $configurationFile
     */
    public function __construct($rootDirectory, $configurationFile = '/composer.json')
    {
        $this->rootDirectory = $rootDirectory;
        $this->configurationFile = $configurationFile;
    }

    /**
     * Fetches the root directory of the project
     *
     * @return string
     */
    public function getRootDirectory()
    {
        return $this->rootDirectory;
    }

    /**
     * fetches the configuration file
     */
    public function getConfigurationFile()
    {
        return $this->rootDirectory . $this->configurationFile;
    }

    /**
     * Returns an object of the composer.json
     * @return object
     */
    public function getConfiguration()
    {
        $configurationFile = $this->getConfigurationFile();
        $configurationFileContents = file_get_contents($configurationFile);
        return json_decode($configurationFileContents);
    }
}