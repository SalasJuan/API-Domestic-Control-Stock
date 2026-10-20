<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Entity\PurchaseDetail\PurchaseDetail;
use Src\Entity\PurchaseDetail\Exception\InvalidPurchaseDetailQuantityException;
use Src\Entity\PurchaseDetail\Exception\InvalidPurchaseDetailUnitPriceException;

final class PurchaseDetailTest extends TestCase
{
    public function testCalculatesSubtotalCorrectly(): void
    {
        $detail = PurchaseDetail::create(
            1,
            2,
            '1500.00'
        );

        self::assertSame('3000.00', $detail->subtotal());
    }

    public function testRejectsQuantityEqualToZero(): void
    {
        $this->expectException(
            InvalidPurchaseDetailQuantityException::class
        );

        PurchaseDetail::create(
            1,
            0,
            '1500.00'
        );
    }

    public function testRejectsInvalidUnitPrice(): void
    {
        $this->expectException(
            InvalidPurchaseDetailUnitPriceException::class
        );

        PurchaseDetail::create(
            1,
            2,
            'precio-invalido'
        );
    }
}