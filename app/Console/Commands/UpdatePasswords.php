<?php

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UpdatePasswords extends Command
{
    protected $signature = 'passwords:update';

    protected $description = 'Update passwords to Bcrypt algorithm';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->password = Hash::make($user->password);
            $user->save();
        }

        $this->info('Passwords updated successfully!');
    }
}
