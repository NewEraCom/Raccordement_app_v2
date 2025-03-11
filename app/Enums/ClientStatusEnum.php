<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self NEW()
 * @method static self AFFECTED()
 * @method static self DECLARED()
 * @method static self VALIDATED()
 * @method static self SAISIE()
 */
class ClientStatusEnum extends Enum
{
    public const NEW = 'Créé';
    public const AFFECTED = 'Affecté';
    public const DECLARED = 'Déclaré';
    public const VALIDATED = 'Validée';
    public const HASH = '#';
}
