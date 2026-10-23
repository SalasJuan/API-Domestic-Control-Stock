<?php
declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Entity\PurchaseDetail\PurchaseDetail;

use Src\Entity\PurchaseDetail\Exception\InvalidPurchaseDetailProductIdException;
use Src\Entity\PurchaseDetail\Exception\InvalidPurchaseDetailPurchaseIdException;
use Src\Entity\PurchaseDetail\Exception\InvalidPurchaseDetailQuantityException;
use Src\Entity\PurchaseDetail\Exception\InvalidPurchaseDetailUnitPriceException;

final class PurchaseDetailTest extends TestCase
{
    //----PRODUCT_ID----//

    public function testRejectsInvalidProductId(): void
    {
        $this->expectException(
            InvalidPurchaseDetailProductIdException::class
        );

        PurchaseDetail::create(0, 2, '1500.00');
    }

    //----QUANTITY----//

    public function testRejectsQuantityEqualToZero(): void
    {
        $this->expectException(
            InvalidPurchaseDetailQuantityException::class
        );

        PurchaseDetail::create(1, 0, '1500.00');
    }

    public function testRejectsNegativeQuantity(): void
    {
        $this->expectException(
            InvalidPurchaseDetailQuantityException::class
        );

        PurchaseDetail::create(1, -1, '1500.00');
    }

    public function testCreatesDetailWithValidQuantity(): void
    {
        $detail = PurchaseDetail::create(1, 5, '1500.00');

        self::assertSame(5, $detail->quantity());
    }

    //----UNIT PRICE----//

    public function testRejectsInvalidUnitPrice(): void
    {
        $this->expectException(
            InvalidPurchaseDetailUnitPriceException::class
        );

        PurchaseDetail::create(1, 2, 'precio-invalido');
    }

    public function testRejectsUnitPriceWithMoreThanTwoDecimals(): void
    {
        $this->expectException(
            InvalidPurchaseDetailUnitPriceException::class
        );

        PurchaseDetail::create(1, 2, '1500.123');
    }

    public function testRejectsNegativeUnitPrice(): void
    {
        $this->expectException(
            InvalidPurchaseDetailUnitPriceException::class
        );

        PurchaseDetail::create(1, 2, '-1500.00');
    }

    //----SUBTOTAL----//

    public function testCalculatesSubtotalCorrectly(): void
    {
        $detail = PurchaseDetail::create(1, 2, '1500.00');

        self::assertSame('3000.00', $detail->subtotal());
    }

    public function testCalculatesSubtotalWithDecimalUnitPrice(): void
    {
        $detail = PurchaseDetail::create(1, 3, '10.50');

        self::assertSame('31.50', $detail->subtotal());
    }

    // ----Modify----//

    public function testModifyUpdatesDetailAndRecalculatesSubtotal(): void
    {
        $detail = PurchaseDetail::create(1, 2, '1500.00');

        $detail->modify(3, 4, '200.50');

        self::assertSame(3, $detail->product_id());
        self::assertSame(4, $detail->quantity());
        self::assertSame('200.50', $detail->unit_price());
        self::assertSame('802.00', $detail->subtotal());
    }

    public function testModifyRejectsInvalidQuantityWithoutChangingDetail(): void
    {
        $detail = PurchaseDetail::create(1, 2, '1500.00');

        try {
            $detail->modify(3, 0, '200.50');

            self::fail(
                'Se esperaba InvalidPurchaseDetailQuantityException.'
            );
        } catch (InvalidPurchaseDetailQuantityException) {
            self::assertSame(1, $detail->product_id());
            self::assertSame(2, $detail->quantity());
            self::assertSame('1500.00', $detail->unit_price());
            self::assertSame('3000.00', $detail->subtotal());
        }
    }

    // ----Assign Purchase----//


    public function testAssignPurchaseSetsPurchaseId(): void
    {
        $detail = PurchaseDetail::create(1, 2, '1500.00');

        $detail->assignPurchase(10);

        self::assertSame(10, $detail->purchase_id());
    }

    public function testAssignPurchaseRejectsInvalidId(): void
    {
        $this->expectException(
            InvalidPurchaseDetailPurchaseIdException::class
        );

        $detail = PurchaseDetail::create(1, 2, '1500.00');

        $detail->assignPurchase(0);
    }

    // ----DELETE----//

    public function testNewDetailIsNotDeleted(): void
    {
        $detail = PurchaseDetail::create(1, 2, '1500.00');

        self::assertSame(0, $detail->isDeleted());
    }

    public function testDeleteMarksDetailAsDeleted(): void
    {
        $detail = PurchaseDetail::create(1, 2, '1500.00');

        $detail->delete();

        self::assertSame(1, $detail->isDeleted());
    }

    // ----RESTORE----//

    public function testRestoreMarksDetailAsNotDeleted(): void
    {
        $detail = PurchaseDetail::create(1, 2, '1500.00');

        $detail->delete();
        $detail->restore();

        self::assertSame(0, $detail->isDeleted());
    }
}