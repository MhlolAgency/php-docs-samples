<?php
/**
 * Copyright 2016 Google Inc.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/storage/README.md
 */

namespace Google\Cloud\Samples\Storage;

# [START list_objects_with_prefix]
use Google\Cloud\Storage\StorageClient;

/**
 * List Cloud Storage bucket objects with specified prefix.
 *
 * @param string $bucketName the name of your Cloud Storage bucket.
 *
 * @return void
 */
function list_objects_with_prefix($bucketName, $prefix)
{
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);
    $options = ['prefix' => $prefix];
    foreach ($bucket->objects($options) as $object) {
        printf('Object: %s' . PHP_EOL, $object->name());
    }
}
# [END list_objects_with_prefix]
