<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;
    
    /* protected static $migration_run = false;

    public function setUp(): void{
        parent::setUp();
    
        if(!static::$migration_run){
            $this->artisan('migrate:refresh');
            $this->artisan('db:seed');
            $this->artisan('passport:install', ['--no-interaction' => true, '--force' => true,]);
            static::$migration_run = true;
        }
    } */
}
