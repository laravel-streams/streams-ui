<?php

namespace Streams\Ui\Tests;

use ReflectionClass;
use Streams\Ui\UiServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class UiServiceProviderTest extends UiTestCase
{
    protected string $languagePath;

    protected function getEnvironmentSetUp($app): void
    {
        $this->languagePath = sys_get_temp_dir().'/streams-ui-lang-'.bin2hex(random_bytes(8));
        $app->useLangPath($this->languagePath);
    }

    protected function tearDown(): void
    {
        try {
            parent::tearDown();
        } finally {
            (new Filesystem)->deleteDirectory($this->languagePath);
        }
    }

    public function test_lang_tag_publishes_ui_language_files(): void
    {
        $source = dirname((new ReflectionClass(UiServiceProvider::class))->getFileName()).'/../resources/lang';

        $paths = ServiceProvider::pathsToPublish(UiServiceProvider::class, 'lang');

        $this->assertArrayHasKey($source, $paths);
        $this->assertSame(lang_path('vendor/ui'), $paths[$source]);
        $this->assertFileExists($source.'/en/labels.php');
    }

    public function test_vendor_publish_lang_copies_ui_translations(): void
    {
        $source = dirname(__DIR__).'/resources/lang';
        $destination = $this->app->langPath('vendor/ui');

        $this->assertDirectoryDoesNotExist($destination);

        $this->artisan('vendor:publish', ['--tag' => 'lang'])
            ->assertExitCode(0);

        $files = (new Filesystem)->allFiles($source);

        $this->assertNotEmpty($files);

        foreach ($files as $file) {
            $published = $destination.'/'.$file->getRelativePathname();

            $this->assertFileExists($published);
            $this->assertFileEquals($file->getPathname(), $published);
        }
    }
}
