<?php

namespace Streams\Ui\Tests;

use ReflectionClass;
use Streams\Ui\UiServiceProvider;
use Illuminate\Support\ServiceProvider;

class UiServiceProviderTest extends UiTestCase
{
    public function test_lang_tag_publishes_ui_language_files()
    {
        $source = dirname((new ReflectionClass(UiServiceProvider::class))->getFileName()).'/../resources/lang';

        $paths = ServiceProvider::pathsToPublish(UiServiceProvider::class, 'lang');

        $this->assertArrayHasKey($source, $paths);
        $this->assertSame(lang_path('vendor/ui'), $paths[$source]);
        $this->assertFileExists($source.'/en/labels.php');
    }
}
