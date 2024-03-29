<?php

namespace App\Console\Commands;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Console\Command;

class SuperadminCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:superadmin_creation 
                            {e : user email} 
                            {p : user_password}
                            {n : user_name}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roles = Roles::where('machine_id', '=', 'admin')->first();
        if(empty($roles)){
            $roles = Roles::create([
                'machine_id' => 'admin',
                'name' => 'admin',
            ]);
        }
        $role_id = $roles->getAttribute('id');
        $users = User::whereHas('role', function($query) {
            $query->where('machine_id', '=', 'admin');
        })->get()->all();
        if(empty($users)){
            $user = User::create([
                'email' => $this->argument('e'),
                'password' => bcrypt($this->argument('p')),
                'name' => $this->argument('n'),
                'role_id' => $role_id,
                'phone' => 0,
                'tipo_id' => 'admin',
                'id_number' => '0',
                'full_id' => 'admin',
            ]);
            $token = $user->createToken('superadminToken')->plainTextToken;
            $this->info('Superadmin created succesfully, check this token: ' . $token);
        } else {
            $this->error('There is a superadmin already');
        }
    }
   
    /**
    * Prompt for missing input arguments using the returned questions.
    *
    * @return array<string, string>
    */

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            '-e' => 'mission email for admin user',
            '-p' => 'mission password for admin user',
            '-n' => 'mission name for admin user',
        ];
    }
}
