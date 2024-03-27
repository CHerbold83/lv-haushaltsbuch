<?php

namespace App;

enum FinanceType:string{
    case Income = 'income';
    case Expenses = 'expenses';

    public static function values(): array
    {
        return array_column(FinanceType::cases(), 'value');
    }

    public function getLabel(): string
    {
        return $this-> value;
    }
}