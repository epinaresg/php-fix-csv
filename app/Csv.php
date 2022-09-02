<?php

namespace App;

class Csv
{

  private $columns = [
    'Rates' => 3,
    'Taxes' => 4,
  ];

  private $csv = [];
  private $rates = 0;
  private $taxes = 0;
  private $total = 0;

  public function printTable(): void
  {
    include('../app/views/table.php');
  }

  public function setFile(array $file): void
  {
    $this->csv = array_map('str_getcsv', file($file['tmp_name']));
  }

  public function computeTotals(): void
  {

    for ($i=1; $i < count($this->csv); $i++) { 

      //$this->taxes += (int) $row[3];
      //$this->rates += (int) $row[4];

      $row = $this->csv[$i];
      
      $this->rates += (int) $row[$this->columns['Rates']];
      $this->taxes += (int) $row[$this->columns['Taxes']];
      //$this->total += (int) $row[$this->columns['Rates']] + (int) $row[$this->columns['Taxes']];
    }
    
    $this->total = $this->rates + $this->taxes;

    array_push($this->csv, ['', '', 'Subtotal', $this->rates, '']);
    array_push($this->csv, ['', '', 'Total', $this->total, '']);
  }
}