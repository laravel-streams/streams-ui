<?php

namespace Streams\Ui\Tests\Builders\Calendars;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\ViewBuilder;
use Illuminate\Contracts\Support\Htmlable;
use Streams\Ui\Builders\Calendars\Calendar;
use Streams\Ui\Builders\Containers\Section;

class CalendarTest extends UiTestCase
{
    protected function getTestCalendar(): Calendar
    {
        return Calendar::make('events-calendar');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $calendar = $this->getTestCalendar();

        $this->assertInstanceOf(Builder::class, $calendar);
        $this->assertInstanceOf(ViewBuilder::class, $calendar);
        $this->assertInstanceOf(Section::class, $calendar);
        $this->assertInstanceOf(Htmlable::class, $calendar);
    }

    /** @test */
    public function it_has_default_view()
    {
        $calendar = $this->getTestCalendar();

        $this->assertEquals('ui::builders.calendar', $calendar->getView());
    }

    /** @test */
    public function it_can_set_and_get_events()
    {
        $calendar = $this->getTestCalendar();
        $events = [
            [
                'title' => 'Board Meeting',
                'start' => '2026-05-26T10:00:00',
                'end' => '2026-05-26T11:00:00',
            ],
        ];

        $result = $calendar->events($events);

        $this->assertSame($calendar, $result);
        $this->assertEquals($events, $calendar->getEvents());
    }

    /** @test */
    public function it_can_merge_calendar_options()
    {
        $calendar = $this->getTestCalendar()
            ->options([
                'weekends' => false,
            ])
            ->mergeOptions([
                'headerToolbar' => [
                    'left' => 'prev,next today',
                    'center' => 'title',
                    'right' => 'dayGridMonth,timeGridWeek',
                ],
            ]);

        $this->assertEquals([
            'weekends' => false,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek',
            ],
        ], $calendar->getOptions());
    }

    /** @test */
    public function it_builds_a_fullcalendar_config_array()
    {
        $calendar = $this->getTestCalendar()
            ->events([
                [
                    'title' => 'Launch Day',
                    'start' => '2026-05-26',
                ],
            ])
            ->initialView('timeGridWeek')
            ->locale('en')
            ->timezone('America/Chicago')
            ->options([
                'weekends' => false,
            ]);

        $this->assertEquals([
            'initialView' => 'timeGridWeek',
            'locale' => 'en',
            'timeZone' => 'America/Chicago',
            'weekends' => false,
            'events' => [
                [
                    'title' => 'Launch Day',
                    'start' => '2026-05-26',
                ],
            ],
        ], $calendar->getConfig());
    }

    /** @test */
    public function it_renders_fullcalendar_markup_and_event_json()
    {
        $calendar = $this->getTestCalendar()
            ->heading('Team Calendar')
            ->events([
                [
                    'title' => 'Board Meeting',
                    'start' => '2026-05-26T10:00:00',
                ],
            ]);

        $html = $calendar->toHtml();

        $this->assertIsString($html);
        $this->assertStringContainsString('fullcalendar@6.1.17', $html);
        $this->assertStringContainsString('events-calendar', $html);
        $this->assertStringContainsString('Board Meeting', $html);
        $this->assertStringContainsString('Team Calendar', $html);
    }
}
