<?php

namespace App\Enums;

enum ChecklistInputType: string
{
    case Checkbox = 'checkbox';
    case Text = 'text';
    case Number = 'number';
    case Choice = 'choice';

    public function label(): string
    {
        return match ($this) {
            self::Checkbox => 'Checkbox',
            self::Text => 'Text',
            self::Number => 'Number',
            self::Choice => 'Choice',
        };
    }
}
