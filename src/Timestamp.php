<?php declare(strict_types=1);

/*
 * This file is part of Timestamp.
 *
 * (c) Stefan Priebsch <stefan@priebsch.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spriebsch\timestamp;

use DateTimeImmutable;
use DateTimeZone;

final class Timestamp
{
    private DateTimeImmutable $dateTime;

    public static function generate(): self
    {
        return new self(new DateTimeImmutable('now'));
    }

    public static function from(string $iso3339): self
    {
        return new self(DateTimeImmutable::createFromFormat('Y-m-d\TH:i:sO.u', $iso3339));
    }

    public static function fromDateTime(DateTimeImmutable $dateTime): self
    {
        return new self($dateTime);
    }

    private function __construct(DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function asDateTime(?DateTimeZone $timeZone = null): DateTimeImmutable
    {
        if ($timeZone === null) {
            $timeZone = $this->defaultTimezone();
        }

        return $this->dateTime->setTimezone($timeZone);
    }

    public function asString(): string
    {
        return $this->dateTime->setTimezone(new DateTimeZone('UTC'))->format('c.u');
    }

    private function defaultTimezone(): DateTimeZone
    {
        return new DateTimeZone(date_default_timezone_get());
    }
}
