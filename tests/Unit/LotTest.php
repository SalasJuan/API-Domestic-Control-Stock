<?php

declare(strict_types=1);

namespace Tests\Unit;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Src\Entity\Lot\Lot;

use Src\Entity\Lot\Exception\InvalidLotQuantityException;
use Src\Entity\Lot\Exception\InvalidLotExpirationDateException;

final class LotTest extends TestCase
{
    //--PURCHASE_DETAIL_ID--//
    
    public function testRejectsInvalidPurchaseDetailId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');
        
        Lot::create(0, 1, 5, $purchaseDate, $expirationDate);
    }
    

    //----PRODUCT_ID----//

    public function testRejectsInvalidProductId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        Lot::create(1, -1, 5, $purchaseDate, $expirationDate);
    }

    //---------------------------------------------------//

    public function testUpdateProductRejectsInvalidId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        $lot->updateProduct(0);
    }
    public function testUpdateProductChangesProductId(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        $lot->updateProduct(2);

        self::assertSame(2, $lot->product_id());
    }

    // ----QUANTITY----//

    public function testRejectsQuantityEqualToZero(): void
    {
        $this->expectException(InvalidLotQuantityException::class);

        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        Lot::create(1, 1, 0, $purchaseDate, $expirationDate);
    }

    public function testRejectsNegativeQuantity(): void
    {
        $this->expectException(
            InvalidLotQuantityException::class
        );

        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        Lot::create(1, 1, -1, $purchaseDate, $expirationDate);
    }

    public function testCreatesLotWithValidQuantity(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1 , 5, $purchaseDate, $expirationDate);

        self::assertInstanceOf(Lot::class, $lot);
        self::assertSame(5, $lot->quantity());
    }

    //---------------------------------------------------//

    public function testUpdateQuantityRejectsZero(): void
    {
        $this->expectException(InvalidLotQuantityException::class);

        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        $lot->updateQuantity(0);
    }
    public function testUpdateQuantityChangesQuantity(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        $lot->updateQuantity(8);

        self::assertSame(8, $lot->quantity());
    }

    // ----Modify----//

    public function testModifyRejectsInvalidQuantityWithoutChangingLot(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        try {
            $lot->modify(2, 3, 0, $purchaseDate, $expirationDate);
            self::fail('Se esperaba InvalidLotQuantityException.');

        } catch (InvalidLotQuantityException) {
            self::assertSame(1, $lot->purchase_detail_id());
            self::assertSame(1, $lot->product_id());
            self::assertSame(5, $lot->quantity());
        }
    }

    public function testModifyUpdatesLotWithValidData(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        $newPurchaseDate = new DateTimeImmutable('today');
        $newExpirationDate = $newPurchaseDate->modify('+60 days');

        $lot->modify(2, 3, 10, $newPurchaseDate, $newExpirationDate);

        self::assertSame(2, $lot->purchase_detail_id());
        self::assertSame(3, $lot->product_id());
        self::assertSame(10, $lot->quantity());
        self::assertSame(
            $newPurchaseDate->format('Y-m-d'),
            $lot->purchase_date()->format('Y-m-d'));

        self::assertSame(
            $newExpirationDate->format('Y-m-d'),
            $lot->expiration_date()->format('Y-m-d'));
    }

    // ----Purchase Date----//
    // ----Expiration Date----//


    public function testRejectsExpirationDateBeforePurchaseDate(): void
    {
        $this->expectException(InvalidLotExpirationDateException::class);
        
        $today = new DateTimeImmutable('today');

        $purchaseDate = $today->modify('+10 days');
        $expirationDate = $today->modify('+5 days');

        Lot::create(1, 1, 5, $purchaseDate, $expirationDate);
    }

    public function testRejectsExpirationDateBeforeToday(): void
    {
        $this->expectException(InvalidLotExpirationDateException::class);

        $purchaseDate = new DateTimeImmutable('today -10 days');
        $expirationDate = new DateTimeImmutable('yesterday');

        Lot::create(1, 1, 5, $purchaseDate, $expirationDate);
    }

    public function testCreatesLotWithExpirationDateAfterPurchaseDate(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        self::assertSame(
            $expirationDate->format('Y-m-d'),
            $lot->expiration_date()->format('Y-m-d')
        );
    }

    // ----DELETE----//

    public function testNewLotIsNotDeleted(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        self::assertSame(0, $lot->isDeleted());
    }

    public function testDeleteMarksLotAsDeleted(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);

        $lot->delete();

        self::assertSame(1, $lot->isDeleted());
    }

    // ----RESTORE----//

    public function testRestoreMarksLotAsNotDeleted(): void
    {
        $purchaseDate = new DateTimeImmutable('today');
        $expirationDate = $purchaseDate->modify('+30 days');

        $lot = Lot::create(1, 1, 5, $purchaseDate, $expirationDate);
        $lot->delete();

        $lot->restore();

        self::assertSame(0, $lot->isDeleted());
    }
}
