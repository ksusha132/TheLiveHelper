<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
class DelExpUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delExp:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление просроченных пользователей';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $user = User::where('activated', 0)->get();
        $time = config('main.expire_user');
        //переводим часы в секунды
        $time = $time * 3600;
        foreach ($user as $u) {
            $date = strtotime($u->created_at) + $time;
            if ($date < time()) { // если created at + час меньше текущего времени то удаляем
                User::find($u->id)->delete();
                $table[] = [$u->id, $u->email];
            }
        };
        $this->info('Удаленные пользователи:');
        $headers = ['ID', 'Email'];
        $this->table($headers, $table);
    }
}
