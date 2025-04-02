<?php declare(strict_types=1);

/*
 * This file is part of Timestamp.
 *
 * (c) Stefan Priebsch <stefan@priebsch.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spriebsch\uuid;

use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use spriebsch\timestamp\Timestamp;

/**
 * @covers \spriebsch\timestamp\Timestamp
 *
 * @group  spriebsch
 * @group  timestamp
 */
class TimestampTest extends TestCase
{
    public function test_can_be_generated(): void
    {
        $before = new DateTimeImmutable(('now'));
        $timestamp = Timestamp::generate();
        $after = new DateTimeImmutable(('now'));

        $this->assertGreaterThanOrEqual($timestamp->asDateTime(), $after);
        $this->assertLessThanOrEqual($timestamp->asDateTime(), $before);
    }

    public function test_can_be_created_from_string(): void
    {
        $timestamp = Timestamp::generate();

        $this->assertEquals($timestamp->asDateTime(), Timestamp::from($timestamp->asString())->asDateTime());
    }

    public function test_can_be_created_from_datetime(): void
    {
        $now = new DateTimeImmutable('now');

        $this->assertEquals($now, Timestamp::fromDateTime($now)->asDateTime());
    }

    public function test_is_serialized_as_UTC(): void
    {
        $now = new DateTimeImmutable('now');
        $nowUTC = $now->setTimezone(new DateTimeZone('UTC'));

        $timestamp = Timestamp::fromDateTime($now);

        $this->assertEquals(
            $nowUTC->format('c.u'),
            $timestamp->asString(),
        );
    }

    public function test_can_be_converted_to_string(): void
    {
        $this->assertIsString(Timestamp::generate()->asString());
    }

    public function test_can_be_converted_to_datetime(): void
    {
        $this->assertInstanceOf(DateTimeImmutable::class, Timestamp::generate()->asDateTime());
    }

    public function test_can_be_converted_to_datetime_with_given_timezone(): void
    {
        $timeZone = new DateTimeZone('HKT');
        $now = new DateTimeImmutable('now');

        $this->assertSame(
            $now->setTimezone($timeZone)->format('c.u'),
            Timestamp::fromDateTime($now)->asDateTime($timeZone)->format('c.u')
        );
    }
}
