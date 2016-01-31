# composer-project-context-plugin
A composer plugin to provide an API to access the Composer's root path and thus, access to composer.json

## What does it do?

The plugin adds a constant BMACK_PROJECTROOT which contains the path to the root path of the
project installed via composer. 

An API class is used for accessing the constant, and is actually there so it can be
enriched in your own application.

## Why?

In the TYPO3 project, we want to work with the composer.json file to detect certain special
parameters. However, this is not possible to detect from the vendor directory during runtime
of your PHP application where your project root directory is.

## Installation

Just require the package to your composer project:

    composer require bmack/composer-projectcontext

## Usage

You have then the constant BMACK_PROJECTROOT in your project when including the autoload file



## License

MIT. Free for everyone, you can even make money off of it.

## Author

Benni Mack <benjamin.mack@gmail.com> starting in 2016.