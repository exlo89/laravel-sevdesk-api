<?php
/*
 * RetrieveSevVersion.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Console;

use Exlo89\LaravelSevdeskApi\Facades\SevdeskApi;
use Illuminate\Console\Command;
use Illuminate\Validation\UnauthorizedException;

class RetrieveSevVersion extends Command
{
    protected $signature = 'sevdesk:version';

    protected $description = 'Retrieve Sev version';

    public function handle()
    {
        $this->info('Check Sevdesk API Key');
        try {
            if (env('SEVDESK_API_TOKEN') !== null && env('SEVDESK_API_TOKEN') !== '') {
                $intance = SevdeskApi::make();
                $this->info('Your sevdesk api version is: ' . $intance->tools()->version()['version']);
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
