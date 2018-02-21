<?php

use mageekguy\atoum\bdd;
use atoum\reports;

//$extension = new bdd\extension($script);
//$runner->addExtension($extension);

$runner
    ->addTestsFromDirectory(__DIR__ . '/tests/units/')
    ->disallowUsageOfUndefinedMethodInMock()
;


$travis = getenv('TRAVIS');
if ($travis) {
    $script->addDefaultReport();
    $coverallsToken = getenv('COVERALLS_REPO_TOKEN');
    if ($coverallsToken) {
        $coverallsReport = new reports\asynchronous\coveralls('classes', $coverallsToken);
        $defaultFinder = $coverallsReport->getBranchFinder();
        $coverallsReport
            ->setBranchFinder(function() use ($defaultFinder) {
                if (($branch = getenv('TRAVIS_BRANCH')) === false) {
                    $branch = $defaultFinder();
                }
                return $branch;
            }
        )
            ->setServiceName('travis-ci')
            ->setServiceJobId(getenv('TRAVIS_JOB_ID'))
            ->addDefaultWriter()
            ;
        $runner->addReport($coverallsReport);
    }
}
