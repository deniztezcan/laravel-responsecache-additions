<?php

namespace DenizTezcan\ResponseCache\Replacers;

use Symfony\Component\HttpFoundation\Response;
use Spatie\ResponseCache\Replacers\Replacer;

class BladeFilesReplacer extends Replacer
{
    protected string | array $htmlTag = 'fake-html-tag'; // html tag without the <> in string or array format
    protected string | array $realTimeView = 'partials.fake-blade-loc'; // blade path string or array format

    public function prepareResponseToCache(Response $response): void
    {
        if (!$response->getContent()) {
            return;
        }

        if (gettype($this->htmlTag) == "string"){
            $content    = $response->getContent();
            $regex      = "#<\s*?{$this->htmlTag}\b[^>]*>(.*?)</{$this->htmlTag}\b[^>]*>#s";
            $view       = view($this->realTimeView);
            preg_match($regex, $content, $matches);
            
            $response->setContent(str_replace(
                $matches,
                $view->render(),
                $response->getContent()
            ));
        } else {
            foreach ($this->htmlTag as $key => $tag) {
                $content    = $response->getContent();
                $regex      = "#<\s*?{$tag}\b[^>]*>(.*?)</{$tag}\b[^>]*>#s";
                $view       = view($this->realTimeView[$key]);
                preg_match($regex, $content, $matches);
                
                $response->setContent(str_replace(
                    $matches,
                    $view->render(),
                    $response->getContent()
                ));
            }
        }
    }

    public function replaceInCachedResponse(Response $response): void
    {
        if (!$response->getContent()) {
            return;
        }

        if (gettype($this->htmlTag) == "string"){
            $content    = $response->getContent();
            $regex      = "#<\s*?{$this->htmlTag}\b[^>]*>(.*?)</{$this->htmlTag}\b[^>]*>#s";
            $view       = view($this->realTimeView);
            preg_match($regex, $content, $matches);
            
            $response->setContent(str_replace(
                $matches,
                $view->render(),
                $response->getContent()
            ));
        } else {
            foreach ($this->htmlTag as $key => $tag) {
                $content    = $response->getContent();
                $regex      = "#<\s*?{$tag}\b[^>]*>(.*?)</{$tag}\b[^>]*>#s";
                $view       = view($this->realTimeView[$key]);
                preg_match($regex, $content, $matches);
                
                $response->setContent(str_replace(
                    $matches,
                    $view->render(),
                    $response->getContent()
                ));
            }
        }
    }
}
