<?php

define('CONSOLE_PATH', realpath(__DIR__ . '/../bin'));

passthru(sprintf('php %s/console doctrine:database:drop --force --env=test ', CONSOLE_PATH));
passthru(sprintf('php %s/console doctrine:database:create --env=test ', CONSOLE_PATH));
passthru(sprintf('php %s/console doctrine:schema:update --force --env=test ', CONSOLE_PATH));

