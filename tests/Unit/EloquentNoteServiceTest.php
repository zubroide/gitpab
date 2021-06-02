<?php

namespace Tests\Unit;

use App\Model\Entity\Note;
use App\Model\Service\Eloquent\EloquentNoteService;
use App\Providers\AppServiceProvider;
use Tests\TestCase;

class EloquentNoteServiceTest extends TestCase
{

    public function setUp()
    {
        $this->createApplication();
    }

    /**
     * @dataProvider parseTimeDataProvider
     *
     * @param string $time
     * @param float $expectedHours
     * @throws \ReflectionException
     */
    public function testParseTime(string $time, float $expectedHours)
    {
        $method = $this->getMethod(EloquentNoteService::class, 'parseTime');
        /** @var EloquentNoteService $service */
        $service = app(AppServiceProvider::ELOQUENT_NOTE_SERVICE);
        $hours = $method->invokeArgs($service, [$time]);
        $this->assertEquals($expectedHours, $hours);
    }

    public function parseTimeDataProvider()
    {
        return [
            [
                'time' => '0s',
                'hours' => 0,
            ],
            [
                'time' => '36s',
                'hours' => 0.01,
            ],
            [
                'time' => '360s',
                'hours' => 0.1,
            ],
            [
                'time' => '0m',
                'hours' => 0,
            ],
            [
                'time' => '30m',
                'hours' => 0.5,
            ],
            [
                'time' => '0h',
                'hours' => 0,
            ],
            [
                'time' => '0.25h',
                'hours' => 0.25,
            ],
            [
                'time' => '0d',
                'hours' => 0,
            ],
            [
                'time' => '0.5d',
                'hours' => 4,
            ],
            [
                'time' => '1d',
                'hours' => 8,
            ],
            [
                'time' => '1.25d',
                'hours' => 10,
            ],
            [
                'time' => '0w',
                'hours' => 0,
            ],
            [
                'time' => '0.5w',
                'hours' => 20,
            ],
            [
                'time' => '1w',
                'hours' => 40,
            ],
        ];
    }

    /**
     * @dataProvider parseSpentTimeItemDataProvider
     *
     * @param array $itemData
     * @param array $prevItemData
     * @param array $expectedRow
     * @return void
     * @throws \ReflectionException
     */
    public function testParseSpentTimeItem(array $itemData, array $prevItemData = null, array $expectedRow)
    {
        $method = $this->getMethod(EloquentNoteService::class, 'parseSpentTimeItem');
        /** @var EloquentNoteService $service */
        $service = app(AppServiceProvider::ELOQUENT_NOTE_SERVICE);
        $item = new Note($itemData);
        $prev = $prevItemData ? new Note($prevItemData) : null;
        $row = $method->invokeArgs($service, [$item, $prev]);
        $this->assertEquals($expectedRow['hours'], $row['hours']);
        $this->assertEquals($expectedRow['spent_at'], $row['spent_at']);
        $this->assertEquals($expectedRow['gitlab_created_at'], $row['gitlab_created_at']);
        $this->assertEquals($expectedRow['description'], $row['description']);
    }

    public function parseSpentTimeItemDataProvider()
    {
        return [
            [
                'itemData' => [],
                'prevItemData' => null,
                'expectedRow' => [
                    'hours' => null,
                    'spent_at' => null,
                    'gitlab_created_at' => null,
                    'description' => null,
                ],
            ],
            [
                'itemData' => [
                    'body' => 'added 1h 30m of time spent at 2018-11-24 just now ',
                    'gitlab_created_at' => '2018-01-01T12:12:13',
                ],
                'prevItemData' => null,
                'expectedRow' => [
                    'hours' => 1.5,
                    'spent_at' => '2018-11-24',
                    'gitlab_created_at' => '2018-01-01T12:12:13',
                    'description' => null,
                ],
            ],
            [
                'itemData' => [
                    'body' => 'added 1h 30m 36s of time spent at 2018-11-14 just now ',
                    'gitlab_created_at' => '2018-01-01T12:12:13',
                ],
                'prevItemData' => null,
                'expectedRow' => [
                    'hours' => 1.51,
                    'spent_at' => '2018-11-14',
                    'gitlab_created_at' => '2018-01-01T12:12:13',
                    'description' => null,
                ],
            ],

            [
                'itemData' => [
                    'body' => 'test two near comments without hours',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'test_prev',
                    'gitlab_created_at' => '2018-01-02T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => null,
                    'spent_at' => null,
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                    'description' => 'test_prev',
                ],
            ],
            [
                'itemData' => [
                    'body' => 'test two near comments without hours (separated)',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'test_prev',
                    'gitlab_created_at' => '2018-01-01T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => null,
                    'spent_at' => null,
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                    'description' => null,
                ],
            ],

            [
                'itemData' => [
                    'body' => 'test two near comments, previous with hours',
                    'gitlab_created_at' => '2018-01-01T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'added 1h 30m of time spent at 2018-11-24 just now',
                    'gitlab_created_at' => '2018-01-01T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => null,
                    'spent_at' => null,
                    'gitlab_created_at' => '2018-01-01T12:12:12',
                    'description' => 'added 1h 30m of time spent at 2018-11-24 just now',
                ],
            ],
            [
                'itemData' => [
                    'body' => 'test two near comments, previous with hours (separated)',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'added 1h 30m of time spent at 2018-11-24 just now',
                    'gitlab_created_at' => '2018-01-01T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => null,
                    'spent_at' => null,
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                    'description' => null,
                ],
            ],

            [
                'itemData' => [
                    'body' => 'added 2h of time spent at 2018-11-21 just now',
                    'gitlab_created_at' => '2018-01-01T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'added 1h 30m of time spent at 2018-11-24 just now',
                    'gitlab_created_at' => '2018-01-01T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => 2,
                    'spent_at' => '2018-11-21',
                    'gitlab_created_at' => '2018-01-01T12:12:12',
                    'description' => 'added 1h 30m of time spent at 2018-11-24 just now',
                ],
            ],
            [
                'itemData' => [
                    'body' => 'added 2h of time spent at 2018-11-23 just now',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'added 1h 30m of time spent at 2018-11-24 just now',
                    'gitlab_created_at' => '2018-01-01T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => 2,
                    'spent_at' => '2018-11-23',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                    'description' => null,
                ],
            ],

            [
                'itemData' => [
                    'body' => 'added 3h 30m of time spent at 2018-11-24 just now',
                    'gitlab_created_at' => '2018-01-01T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'test primary with hours',
                    'gitlab_created_at' => '2018-01-01T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => 3.5,
                    'spent_at' => '2018-11-24',
                    'gitlab_created_at' => '2018-01-01T12:12:12',
                    'description' => 'test primary with hours',
                ],
            ],
            [
                'itemData' => [
                    'body' => 'added 4h 30m of time spent at 2018-11-24 just now',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'test primary with hours (separated)',
                    'gitlab_created_at' => '2018-01-01T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => 4.5,
                    'spent_at' => '2018-11-24',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                    'description' => null,
                ],
            ],
            [
                'itemData' => [
                    'body' => 'added 4h 30m of time spent',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                ],
                'prevItemData' => [
                    'body' => 'test primary with hours (separated)',
                    'gitlab_created_at' => '2018-01-01T12:12:11',
                ],
                'expectedRow' => [
                    'hours' => 4.5,
                    'spent_at' => '2018-01-02T12:12:12',
                    'gitlab_created_at' => '2018-01-02T12:12:12',
                    'description' => null,
                ],
            ],
        ];
    }

}
