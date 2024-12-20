<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install the api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // retrieve user
        $user = User::find(1);

        // check for user
        if (!$user) {
            $this->error('Unable to identify the user specified! Did you run the migrations and seeder?');

            return false;
        }

        // expire previous tokens
        $user->tokens()->update([
            'expires_at'    => now(),
        ]);

        // generate new token
        $token = $user->createToken('atarim-api', ['url:encode', 'url:decode']);

        // check for token
        if ($token) {
            // show token
            $this->warn('Please copy the following api token as you will not be able to access it again.');
            $this->info('API Token: ' . $token->plainTextToken);

            return false;
        } 

        // error
        $this->error('Unable to create a token for the user specified!');

        return false;
    }
}
