<?php


namespace Exlo89\LaravelSevdeskApi\Facades\Console;


use Illuminate\Console\Command;

class InstallSevdeskApi extends Command
{
    protected $signature = 'sevdesk-api:install';

    protected $description = 'Install Sevdesk Api';

    public function handle()
    {
        $this->info('Installing Sevdesk Api...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "Exlo89\LaravelSevdeskApi\LaravelSevdeskApiServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Installed Sevdesk Api');
    }
}
