<?php

namespace Elastic\Driver;

use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Http;

class ElasticManagement 
{
    
    public function execute($options, $query)
    {
        try {
            $response = Http::withBasicAuth('taylor@laravel.com', 'secret')->${$query->method}->get();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}
