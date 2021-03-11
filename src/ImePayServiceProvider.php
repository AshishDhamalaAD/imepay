<?php

namespace Asdh\ImePay;

use Asdh\ImePay\Commands\ImePayCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ImePayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('imepay')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_imepay_table')
            ->hasCommand(ImePayCommand::class);
    }
}
