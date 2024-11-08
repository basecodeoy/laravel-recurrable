<?php

declare(strict_types=1);

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;

/**
 * @internal
 *
 * @covers \BaseCodeOy\Recurrable\Builder
 */
final class BuilderTest extends TestCase
{
    public function test_next_returns_carbon_instance(): void
    {
        $recurring = new RecurrableClass(['count' => 2]);

        $builder = $recurring->recurr();

        self::assertTrue($builder->next() instanceof Carbon);
    }

    public function test_next_returns_false_if_no_more_recurrances(): void
    {
        $recurring = new RecurrableClass(['count' => 1]);

        $builder = $recurring->recurr();

        self::assertFalse($builder->next());
    }
}

final class RecurrableClass
{
    use \BaseCodeOy\Recurrable\Concerns\Recurrable;

    private string $start_at;

    private string $end_at;

    private string $timezone;

    private string $frequency;

    private int $interval;

    private int $count;

    public function __construct(array $attributes = [])
    {
        $this->start_at = $attributes['start_at'] ?? Carbon::now()->format('Y-m-d H:i:s');
        $this->end_at = $attributes['end_at'] ?? Carbon::now()->format('Y-m-d H:i:s');
        $this->timezone = $attributes['timezone'] ?? Carbon::now()->format('e');
        $this->frequency = $attributes['frequency'] ?? 'DAILY';
        $this->interval = $attributes['interval'] ?? 1;
        $this->count = $attributes['count'] ?? null;
    }
}
