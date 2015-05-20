<?php

namespace MyVendor\Weekday\Infra;

use Omelet\Annotation\Select;
use Omelet\Annotation\ParamAlt;

interface TodoDao {
    /**
     * @Select
     * @ParamAlt(type=\DateTime::class, name="from")
     * @ParamAlt(type=\DateTime::class, name="to")
     * 
     * @param \DateTime from
     * @param \DateTime to
     */
    function listByPub(\DateTime $from, \DateTime $to);
}
