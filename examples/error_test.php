<?php


require_once __DIR__ .'/__bootstrap.php';

use LTL\Global\GlobalVars;

/**
 * @method static void setLimit(int $limit)
 * @method static int limit()
 * @method static void addLimit(int|float $amount)
 * @method static void addOneLimit()
 */
abstract class AGlobal extends GlobalVars
{

}

AGlobal::setLimit(100);

AGlobal::addLimit(10);

AGlobal::addOneLimit();

dd(AGlobal::limit());
