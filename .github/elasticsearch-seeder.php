<?php

include_once 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->setHosts(['localhost:9200'])->build();

try {
    $client->indices()->delete(['index' => 'ci-index']);
} catch (\Throwable $th) {
}

$client->indices()->create([
    'index' => 'ci-index',
    'body' => [
        'mappings' => [
            'properties' => [
                'name' => [
                    'type' => 'keyword',
                ],
                'description' => [
                    'type' => 'text',
                ],
                'programming_languages' => [
                    'type' => 'keyword',
                ],
                'age' => [
                    'type' => 'long',
                ],
                'required_matches' => [
                    'type' => 'long',
                ],
            ],
        ],
    ],
]);

$client->putScript([
    'id'   => 'ci-stored-script',
    'body' => [
        'script' => [
            'lang'   => 'painless',
            'source' => "doc['name'].value"
        ],
    ]
]);

$client->indices()->refresh();
