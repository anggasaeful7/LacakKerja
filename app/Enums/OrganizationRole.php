<?php

namespace App\Enums;

enum OrganizationRole: string
{
    case Owner = 'owner';
    case Admin = 'admin';
    case Dispatcher = 'dispatcher';
    case Technician = 'technician';

    public function label(): string
    {
        return match ($this) {
            self::Owner => 'Owner',
            self::Admin => 'Admin',
            self::Dispatcher => 'Dispatcher',
            self::Technician => 'Technician',
        };
    }

    public function canManageOrganization(): bool
    {
        return in_array($this, [self::Owner, self::Admin], true);
    }

    public function canManageMembers(): bool
    {
        return in_array($this, [self::Owner, self::Admin], true);
    }

    public function canManageMasterData(): bool
    {
        return in_array($this, [self::Owner, self::Admin, self::Dispatcher], true);
    }
}
