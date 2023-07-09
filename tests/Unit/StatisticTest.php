<?php

namespace Tests\Unit;

use App\Catalogs\Actions\StatisticAction;
use Tests\TestCase;

class StatisticTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_statistic_index(): void
    {
        $stats = new StatisticAction();
        $this->assertIsArray($stats->indexStatistic());
    }
}
