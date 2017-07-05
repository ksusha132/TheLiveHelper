<?php

namespace App\Console\Commands;
use App\Code;
use Illuminate\Console\Command;

class DelExpCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delExp:code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление просроченных кодов';

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
        $code = Code::all();
        $time = config('main.expire_code');
        //переводим часы в секунды
        $time = $time*3600;
        $bar = $this->output->createProgressBar(count($code));
        foreach ($code as $c) {
            $date = strtotime($c->created_at)+$time;
            if($date < time()){
                Code::find($c->id)->delete();
            };
            sleep(1);
            $bar->advance();
        };
        $bar->finish();
    }
}
