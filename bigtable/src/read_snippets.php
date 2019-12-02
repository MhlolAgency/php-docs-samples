<?php

/**
 * Copyright 2019 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/bigtable/README.md
 */

// Include Google Cloud dependencies using Composer
require_once __DIR__ . '/../vendor/autoload.php';

if (count($argv) !== 5) {
    return printf("Usage: php %s PROJECT_ID INSTANCE_ID TABLE_ID" . PHP_EOL, __FILE__);
}
list($_, $project_id, $instance_id, $table_id, $snippet) = $argv;

// [START bigtable_writes_simple]

use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\DataUtil;

/** Uncomment and populate these variables in your code */
// $project_id = 'The Google project ID';
// $instance_id = 'The Bigtable instance ID';
// $table_id = 'mobile-time-series';

// Connect to an existing table with an existing instance.
$dataClient = new BigtableClient([
    'projectId' => $project_id,
]);
$table = $dataClient->table($instance_id, $table_id);

function readRow($table)
{
    $rowkey = "phone#4c410523#20190501";
    $row = $table->readRow($rowkey);

    printRow($rowkey, $row);
}

function readRows($table)
{
    $rowkey = "phone#4c410523#20190501";
//    $rows = $table->readRows([$rowkey, "phone#4c410523#20190502"]);
    $rows = $table->readRows([
        'rowRanges' => [
            [
                'startKeyOpen' => 'phone#4',
                'endKeyOpen' => 'phone#6'
            ]
        ]
    ]);

    foreach ($rows as $row) {
        print_r($row) . PHP_EOL;
    }
}



function printRow($rowkey, $row_data)
{
    printf("Reading data for %s" . PHP_EOL, $rowkey);
    foreach ($row_data as $family => $cols) {
        printf("Column Family %s" . PHP_EOL, $family);
        foreach ($cols as $col => $data) {
            $labels = "";
            for ($i = 0; $i < count($data); $i++) {
                printf("\t%s: %s @%s%s" . PHP_EOL, $col, $data[$i]["value"], $data[$i]["timeStamp"], $labels);

            }
        }
    }
    print (PHP_EOL);
}


call_user_func($snippet, $table);

// [END bigtable_writes_simple]
