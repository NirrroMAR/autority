<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * PTB Component.
 * 
 */
#[AsTwigComponent('ptb')]
class PtbComponent
{
  public string $title = '';
}