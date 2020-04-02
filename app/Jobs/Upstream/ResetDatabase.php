<?php

namespace App\Jobs\Upstream;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDatabase
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->db = DB::connection('upstream');
        $this->schema = Schema::connection('upstream');
    }

    /**
     * Drops all tables from the upstream database so that they can be re-created from Access.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->db->select('SHOW TABLES') as $table) {
            $table_array = get_object_vars($table);
            $this->schema->drop($table_array[key($table_array)]);
        }
    }
}
