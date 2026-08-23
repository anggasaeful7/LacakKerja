<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Cash = 'cash';
    case BankTransfer = 'bank_transfer';
    case Card = 'card';
    case EWallet = 'ewallet';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Cash => 'Tunai',
            self::BankTransfer => 'Transfer bank',
            self::Card => 'Kartu',
            self::EWallet => 'Dompet digital',
            self::Other => 'Lainnya',
        };
    }
}
