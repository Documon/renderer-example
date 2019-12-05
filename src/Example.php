<?php

namespace Documon\Renderer;

use Documon\RendererInterface;
use Exception;

class Example implements RendererInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Markdown constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public static function type(): string
    {
        return 'default';
    }

    /**
     * @inheritDoc
     */
    public static function template(): string
    {
        return __DIR__ . '/../template';
    }

    /**
     * @inheritDoc
     */
    public static function options(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function serveCommand(): string
    {
        return 'yarn dev';
    }

    /**
     * @return string
     */
    public function buildCommand(): string
    {
        return 'yarn build';
    }

    /**
     * @throws Exception
     * @return void
     */
    public function render(): void
    {
        $content = $this->convert();
        $html = $this->renderHtml($content);
        $this->writeHtml($html);
    }

    /**
     * @throws Exception
     * @return string|string[]|null
     */
    protected function convert()
    {
        $filename = $this->config['filename'];

        return file_get_contents($filename);
    }

    /**
     * @param string $html
     *
     * @return string
     */
    protected function renderHtml(string $html): string
    {
        $template = file_get_contents(__DIR__ . '/../template/views/index.html');

        return str_replace('{{ html }}', $html, $template);
    }

    /**
     * @param string $html
     */
    protected function writeHtml(string $html): void
    {
        $outputFile = $this->config['work-dir'] . '/src/index.html';
        file_put_contents($outputFile, $html);
    }
}
