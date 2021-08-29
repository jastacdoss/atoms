<?php

return [
    // AIRFARE
    'PAIR_FARE' => 'YCA_FARE',
    'DEFAULT_AIRFARE' => 600, // Used if more than {{ DRIVEABLE_DISTANCE }} * 2 and no city pair

    // POV
    'DRIVEABLE_DISTANCE' => 50,
    'MILEAGE_RATE' => '0.56', // https://www.gsa.gov/travel/plan-book/transportation-airfare-pov-etc/privately-owned-vehicle-pov-mileage-reimbursement-rates

    // RENTAL CAR
    'RENTAL_RATE' => '58.99', // https://www.gsa.gov/cdnstatic/General_Supplies__Services/STR%20Rate%20FY21%20Q3%20Vehicle%20Rates.pdf

    // MISC
    'METERS_TO_MILES' => '.000621371',
];
