<?php
/**
 * @file
 * Contains \Drupal\service_demo\Fibonacci.
 */

namespace Drupal\service_demo;

/**
 * Contains Fibonacci calculators.
 * @package Drupal\service_demo
 */
class Fibonacci {

  /**
   * Calculates the n-th Fibbonacci number.
   *
   * Sample Fibbonacci sequence: 0, 1, 1, 2, 3, 5, 8, 13, 21
   * The 6th Fibbonacci number is 8.
   *
   * @param int $position
   *   The position in the Fibonacci sequence to calculate.
   *
   * @return int $position
   *   The calculated Fibonacci value.
   *
   * @throws \Exception when input is negative.
   */
  public function calculateNth($position) {
    $fib = 0;
    $int1 = $int2 = 1;

    if ($position < 0) {
      throw new \Exception('Invalid input for Fibonacci calculation.');
    }

    if ($position == 0) {
      return 0;
    }

    if ($position == 1) {
      return 1;
    }

    // Start calculating from $position == 2
    for ($i = 2; $i <= $position; $i++) {
      $fib = $int1 + $int2;
      //swap the values out:
      $int2 = $int1;
      $int1 = $fib;
    }

    return $fib;
  }

}
