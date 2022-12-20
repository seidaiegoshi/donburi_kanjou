<?php

function footer($menu)
{
  $htmlElement = "";
  $htmlElement .= "
  <footer>";
  if ($menu == "home") {
    $htmlElement .= "
    <div class='selected'>";
  } else {
    $htmlElement .= "
    <div>";
  }
  $htmlElement .= "
    <a href='./../home/home.php'>
      HOME
    </a>
  </div>";

  if ($menu == "input") {
    $htmlElement .= "
    <div class='selected'>";
  } else {
    $htmlElement .= "
    <div>";
  }
  $htmlElement .= "
  <a href='./../input/sales_performance.php'>
        INPUT
      </a>
    </div>";

  if ($menu == "analysis") {
    $htmlElement .= "
    <div class='selected'>";
  } else {
    $htmlElement .= "
    <div>";
  }
  $htmlElement .= "
  <a href='./../analysis/monthly_graph.php'>
        ANALYSIS
      </a>    
    </div>";

  if ($menu == "setting") {
    $htmlElement .= "
    <div class='selected'>";
  } else {
    $htmlElement .= "
    <div>";
  }
  $htmlElement .= "
  <a href='./../setting/product_list.php'>
        SETTING
      </a>
    </div>";

  $htmlElement .= "
  <div>ACCOUNT</div>
  </footer>";
  return $htmlElement;
}
