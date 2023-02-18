<?php
/*
 * RetrieveSevUser.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2023 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Console;

use Illuminate\Console\Command;
use Illuminate\Validation\UnauthorizedException;
use Exlo89\LaravelSevdeskApi\Facades\SevdeskApi;

class RetrieveSevUser extends Command
{
    protected $signature = 'sevdesk:user';

    protected $description = 'Retrieve all Sev User';

    public function handle()
    {
        $this->info('Check Sevdesk API Key');
        try {
            if (env('SEVDESK_SEV_USER') !== null && env('SEVDESK_SEV_USER') !== '') {
                $intance = SevdeskApi::make();
                $this->info('Start user request');
                $users = $intance->user()->all();
                if ($users->isEmpty()) {
                    $this->info('No user found.');
                } else {
                    $this->info('Found some users.');
                    $this->info('==========================================================');
                    $users->each(function ($item) {
                        $this->info($item['id'] . ' | ' . $item['fullname'] . ' | ' . $item['email']);
                    });
                    $this->info('==========================================================');
                }
            } else {
                $this->info('API key not set. Please check your .env file.');
            }
        } catch (UnauthorizedException $error) {
            $this->info('Unauthorized: ' . $error->getMessage());
        } catch (\Exception $error) {
            $this->info('Something went wrong: ' . $error->getMessage());
        }
    }
}
