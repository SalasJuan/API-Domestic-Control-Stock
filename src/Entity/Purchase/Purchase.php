<?php 

namespace Src\Entity\Purchase;
use DateTimeImmutable;
use Src\Entity\Purchase\Exception\InvalidPurchaseDateException;
use Src\Entity\Purchase\Exception\InvalidPurchaseStoreException;
use Src\Entity\Purchase\Exception\InvalidPurchaseTotalException;

final class Purchase {

    public function __construct(
        private readonly ?int $id,
        private DateTimeImmutable $date,
        private string $store,
        private string $total,
        private bool $deleted
        ){}

    public static function create(DateTimeImmutable $date, string $store, string $total): self
    {
        self::validateDate($date);
        self::validateStore($store);
        self::validateTotal($total);
        return new self(null, $date, trim($store), $total, false);
        // 'Self' indica Instancia de el mismo Objeto (Purchase)
    }

    public function modify(DateTimeImmutable $date, string $store, string $total): void
    {
        self::validateDate($date);
        self::validateStore($store);
        self::validateTotal($total);
        
        $this->date = $date;
        $this->store = trim($store);
        $this->total = $total;
    }

    public function updateTotal(string $total): void
    {
        self::validateTotal($total);
        $this->total = $total;
    }
    

    private static function validateDate(DateTimeImmutable $date): void {
        $today = new DateTimeImmutable('today');

        if ($date->format('Y-m-d') > $today->format('Y-m-d')) {
            throw new InvalidPurchaseDateException($today, $date);
        }
    }

    private static function validateStore(string $store): void
    {  
        if (trim($store) === '') {
            throw new InvalidPurchaseStoreException();
        }
    }

    private static function validateTotal(string $total): void
    {  
         if (preg_match('/^\d+(?:\.\d{1,2})?$/D', $total) !== 1) {
            throw new InvalidPurchaseTotalException();
        }
    }
    
    public function id(): ?int
    {
        return $this->id;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function store(): string
    {
        return $this->store;
    }

    public function total(): string
    {
        return $this->total;
    }
    
// Consulta Estado 'DELETED'
    public function isDeleted(): int
    {
        return $this->deleted ? 1 : 0;
    }

// Cambia a Estado 'DELETED'
    public function delete(): void
    {
        $this->deleted = true;
    }
}