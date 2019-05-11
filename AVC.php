<?php
namespace{
    use EZAMA\AVC;
    use EZAMA\AVCIterator;

    function count_values($mixed, $getIterator=false)
    {
        return AVC::countValues($mixed, $getIterator);
    }
    function count_diff_values($mixed)
    {
        return AVC::countDiffValues($mixed);
    }
    function value_count($value, $mixed)
    {
        return AVC::valueCount($value, $mixed);
    }
}
