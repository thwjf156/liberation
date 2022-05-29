<?php

namespace Thwjf156\Liberation;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class LiberationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMacro();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function registerMacro()
    {
        Builder::macro('sql', function ($name, $queryParams = [], $bladeParams = []) {
            $sql = Liberation::sql($name, $bladeParams);
            return Db::select($sql, $queryParams);
        });
    }
}
