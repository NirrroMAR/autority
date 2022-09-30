<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Code Highlighter Component.
 * 
 */
#[AsTwigComponent('debuger')]
class DebugerComponent
{
  // declare code property
  public mixed $data = '';
}