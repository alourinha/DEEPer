<?php

// Convert rating number to stars
function star($rate) {
    $starRating = [];
    $increment = 0;
    $max = 5;

    while($increment < $rate) {
        array_push($starRating, "<i class='fas fa-star fa text-success pt-1'></i>");
        $increment++;
    }

    while($max > $rate) {
        array_push($starRating, "<i class='fas fa-star fa text-secondary pt-1'></i>");
        $max--;
    }

    foreach ($starRating as $rating) {
        return $starRating;
    }
}

// Calculate and update Overall Rating
function updateOverallRating($average){
    if ($average > 0){
        return star($average);

    } else {

        echo '<h2>No Reviews to Display</h2>';
    }
}
