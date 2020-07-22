<?php

declare(strict_types=1);

namespace BladeUI\Markdown;

use BladeUI\Component;
use Illuminate\Contracts\View\View;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use League\CommonMark\MarkdownConverterInterface;

class Markdown extends Component
{
    /** @var string */
    protected $flavor;

    /** @var string */
    protected $htmlInput;

    /** @var bool */
    protected $allowUnsafeLinks;

    /** @var array */
    protected $options;

    public function __construct(
        string $flavor = 'default',
        string $htmlInput = 'allow',
        bool $allowUnsafeLinks = true,
        array $options = []
    ) {
        $this->flavor = $flavor;
        $this->htmlInput = $htmlInput;
        $this->allowUnsafeLinks = $allowUnsafeLinks;
        $this->options = $options;
    }

    public function render(): View
    {
        return view('blade-ui::components.markdown.markdown');
    }

    public function toHtml(string $markdown): string
    {
        return $this->converter()->convertToHtml($markdown);
    }

    protected function converter(): MarkdownConverterInterface
    {
        $options = array_merge($this->options, [
            'html_input' => $this->htmlInput,
            'allow_unsafe_links' => $this->allowUnsafeLinks,
        ]);

        if ($this->flavor === 'github') {
            return new GithubFlavoredMarkdownConverter($options);
        }

        return new CommonMarkConverter($options);
    }
}
