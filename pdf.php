<?php
require_once 'dompdf/autoload.inc.php';
require_once 'php/core/init.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
    public function __construct()
    {
        parent::__construct();
    }
}

