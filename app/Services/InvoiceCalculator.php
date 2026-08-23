<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

class InvoiceCalculator
{
    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array{items: array<int, array<string, mixed>>, subtotal: int, discount_amount: int, tax_rate: string, tax_amount: int, total_amount: int}
     */
    public function calculate(array $items, int $discountAmount, string|int|float $taxRate): array
    {
        $normalizedItems = [];
        $subtotal = 0;

        foreach ($items as $index => $item) {
            $description = trim((string) ($item['description'] ?? ''));
            $quantityMilli = $this->decimalToScaled($item['quantity'] ?? null, 3, "items.{$index}.quantity");
            $unitPrice = $this->money($item['unit_price'] ?? null, "items.{$index}.unit_price");

            if ($description === '') {
                throw ValidationException::withMessages(["items.{$index}.description" => 'Deskripsi item wajib diisi.']);
            }

            if ($quantityMilli < 1) {
                throw ValidationException::withMessages(["items.{$index}.quantity" => 'Quantity harus lebih besar dari 0.']);
            }

            $lineTotal = intdiv(($quantityMilli * $unitPrice) + 500, 1000);
            $subtotal += $lineTotal;
            $normalizedItems[] = [
                'service_id' => filled($item['service_id'] ?? null) ? (int) $item['service_id'] : null,
                'description' => $description,
                'quantity' => $this->scaledToDecimal($quantityMilli, 3),
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
            ];
        }

        if ($normalizedItems === []) {
            throw ValidationException::withMessages(['items' => 'Invoice minimal memiliki satu item.']);
        }

        if ($discountAmount < 0 || $discountAmount > $subtotal) {
            throw ValidationException::withMessages(['discount_amount' => 'Diskon tidak boleh melebihi subtotal.']);
        }

        $taxRateHundredths = $this->decimalToScaled($taxRate, 2, 'tax_rate');
        if ($taxRateHundredths > 10000) {
            throw ValidationException::withMessages(['tax_rate' => 'Pajak harus berada di antara 0 dan 100 persen.']);
        }

        $taxableAmount = $subtotal - $discountAmount;
        $taxAmount = intdiv(($taxableAmount * $taxRateHundredths) + 5000, 10000);

        return [
            'items' => $normalizedItems,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_rate' => $this->scaledToDecimal($taxRateHundredths, 2),
            'tax_amount' => $taxAmount,
            'total_amount' => $taxableAmount + $taxAmount,
        ];
    }

    private function money(mixed $value, string $field): int
    {
        if (! is_scalar($value) || ! preg_match('/^\d+$/', trim((string) $value))) {
            throw ValidationException::withMessages([$field => 'Nominal harus berupa bilangan bulat non-negatif.']);
        }

        $money = (int) $value;
        if ($money < 0) {
            throw ValidationException::withMessages([$field => 'Nominal tidak boleh negatif.']);
        }

        return $money;
    }

    private function decimalToScaled(mixed $value, int $scale, string $field): int
    {
        if (! is_scalar($value)) {
            throw ValidationException::withMessages([$field => 'Nilai desimal tidak valid.']);
        }

        $normalized = str_replace(',', '.', trim((string) $value));
        $pattern = '/^(\d+)(?:\.(\d{1,'.$scale.'}))?$/';
        if (! preg_match($pattern, $normalized, $matches)) {
            throw ValidationException::withMessages([$field => 'Nilai desimal tidak valid.']);
        }

        $fraction = str_pad($matches[2] ?? '', $scale, '0');
        $scaled = ((int) $matches[1] * (10 ** $scale)) + (int) $fraction;

        return $scaled;
    }

    private function scaledToDecimal(int $value, int $scale): string
    {
        $base = 10 ** $scale;
        $whole = intdiv($value, $base);
        $fraction = str_pad((string) ($value % $base), $scale, '0', STR_PAD_LEFT);

        return $whole.'.'.$fraction;
    }
}
