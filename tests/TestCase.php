<?php

namespace Tests;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
 protected function setUp(): void
{
    parent::setUp();

    if (config('database.default') === 'sqlite') {
        // Make SQLite accept your weird FK on non-PK column
        DB::statement('CREATE UNIQUE INDEX intervenants_idIntervenant_unique ON intervenants(idIntervenant);');
    }
}

}
