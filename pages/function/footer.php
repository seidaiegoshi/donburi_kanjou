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
      <i class='fa-solid fa-house'></i>
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
        <i class='fa-solid fa-pen'></i>
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
        <i class='fa-solid fa-chart-line'></i>
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
        <i class='fa-solid fa-gear'></i>
      </a>
    </div>";

  $htmlElement .= "
  <div><i class='fa-solid fa-user'></i></div>
  </footer>";
  return $htmlElement;
}
