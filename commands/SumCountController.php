<?php

namespace app\commands;

use app\components\RecursiveCounter;
use yii\console\Controller;

class SumCountController extends Controller
{
    public function actionRun()
    {
        $listDirectories = ['/var/www/forTest'];
        $sum = 0;

        foreach ($listDirectories as $directory) {
            $filter = new RecursiveCounter($directory);
            $sum += $filter->getSum();
        }

        printf($sum . "\n");
    }
}
