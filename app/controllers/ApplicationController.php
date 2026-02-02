<?php

/**
 * Base controller for the application.
 * Add general things in this controller.
 */
class ApplicationController extends Controller
{
  protected function clean_input(string $data): string
  {
    return htmlspecialchars(stripslashes(trim($data)));
  }
}
