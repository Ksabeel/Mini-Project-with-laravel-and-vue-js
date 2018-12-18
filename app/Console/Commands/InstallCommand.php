<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Question\Question;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-vue:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simplify installation process.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->welcome();

        $this->createEnvFile();

        if (strlen(config('app.key')) === 0) {
            $this->call('key:generate');
        }

        $this->line('~ Secret key properly generated.');

        $credentials = $this->requestDatabaseCredentails();

        $this->updateEnvironmentFile($credentials);

        if ($this->confirm('Do you want to migrate the database?', false)) {
            $this->migrateDatabaseWithFreshCredentails($credentials);

            $this->line('~ Database successfully migrated.');

            if ($this->confirm('Do you want to seed your database?', false)) {
                $this->call('db:seed');

                $this->line('~ Seeding successfully');
            }
        }


        $this->call('cache:clear');

        $this->goodbye();
    }

    /**
     * Update the .env file from an array of $key => $value pair.
     * 
     * @param  array $updateValues
     * @return void
     */
    protected function updateEnvironmentFile($updateValues)
    {
        $envFile = $this->laravel->environmentFilePath();

        foreach ($updateValues as $key => $value) {
            file_put_contents($envFile, preg_replace(
                "/{$key}=(.*)/",
                "{$key}={$value}",
                file_get_contents($envFile)
            ));
        }
    }

    /**
     * Display the welcome message.
     * 
     */
    protected function welcome()
    {
        $this->info('>> Welcome to the Laravel+Vue installation process <<');
    }

    /**
     * Display the completion message.
     * 
     */
    protected function goodbye()
    {
        $this->info('>> The installation process is complete. Thanks for the installation.');
    }

    /**
     * Create the initial .env file.
     * 
     */
    protected function createEnvFile()
    {
        if (! file_exists('.env')) {
            copy('.env.example', '.env');

            $this->line('.env file successfully created.');
        }
    }

    /**
     * Migrate the DB with the new credentials.
     * 
     * @param  array $credentials
     * @return void
     */
    protected function migrateDatabaseWithFreshCredentails($credentials)
    {
        foreach ($credentials as $key => $value) {
            $configKey = strtolower(str_replace('DB_', '', $key));

            if ($configKey === 'password' && $value === 'null') {
                config(["database.connections.mysql.{$configKey}" => '']);

                continue;
            }

            config(["database.connections.mysql.{$configKey}" => $value]);
        }

        $this->call('migrate');
    }

    /**
     * Request the local database details form the user.
     *
     * @return array
     */
    protected function requestDatabaseCredentails()
    {
        return [
            'DB_DATABASE' => $this->ask('Database name'),
            'DB_PORT' => $this->ask('Database port', 3306),
            'DB_USERNAME' => $this->ask('Database user'),
            'DB_PASSWORD' => $this->askHiddenWithDefault('Database password (leave blank for no password)'),
        ];
    }

    /**
     * Prompt the user for optinal input but hide the answer form console.
     * 
     * @param  string  $question
     * @param  boolean $fallback
     * @return string
     */
    protected function askHiddenWithDefault($question, $fallback = true)
    {
        $question = new Question($question, '');

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }
}
