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

        $this->assertGreaterThan($timestamp->asDateTime(), $after);
        $this->assertLessThan($timestamp->asDateTime(), $before);
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

    public function test_can_be_converted_to_string(): void
    {
        $this->assertIsString(Timestamp::generate()->asString());
    }

    public function test_can_be_converted_to_datetime(): void
    {
        $this->assertInstanceOf(DateTimeImmutable::class, Timestamp::generate()->asDateTime());
    }
}
