<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent('alert')]
class AlertComponent
{
  public function __construct(
    public string $type = 'success',
    public string $message = 'Success!',
  ) {
  }

  public function getType(): string
  {
    return $this->type;
  }

  public function getMessage(): string
  {
    return $this->message;
  }

  public function getAlertClass(): string
  {
    return match ($this->type) {
      'success' => 'alert-success',
      'error' => 'alert-danger',
      'warning' => 'alert-warning',
      'info' => 'alert-info',
      default => 'alert-primary',
    };
  }

  public function getIcon(): string
  {
    return match ($this->type) {
      'success' => 'fas fa-check-circle',
      'error' => 'fas fa-exclamation-circle',
      'warning' => 'fas fa-exclamation-triangle',
      'info' => 'fas fa-info-circle',
      default => 'fas fa-question-circle',
    };
  }
}
