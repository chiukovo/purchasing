<?php

function format_money_nt($money)
{
    if ($money != 'NaN') {
        return number_format($money, 0, '.', ',');
    }
}