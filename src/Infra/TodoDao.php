<?php

namespace MyVendor\Weekday\Infra;

use Omelet\Annotation\Select;
use Omelet\Annotation\ParamAlt;

interface TodoDao {
    /**
     * @Select
     * 
     * @param DateTime from
     * @param DateTime to
     * @return Todo[]
     */
    function listByPub(\DateTime $from, \DateTime $to);
}
