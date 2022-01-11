<?php

namespace DenizTezcan\ResponseCache\Replacers;

use Symfony\Component\HttpFoundation\Response;
use Spatie\ResponseCache\Replacers\Replacer;

class BladeFilesReplacer implements Replacer
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
            
            if(isset($matches[0])){
                $response->setContent(str_replace(
                    $matches[0],
                    $view->render(),
                    $response->getContent()
                ));
            }
        } else {
            foreach ($this->htmlTag as $key => $tag) {
                $content    = $response->getContent();
                $regex      = "#<\s*?{$tag}\b[^>]*>(.*?)</{$tag}\b[^>]*>#s";
                $view       = view($this->realTimeView[$key]);
                preg_match($regex, $content, $matches);
                
                if(isset($matches[0])){
                    $response->setContent(str_replace(
                        $matches[0],
                        $view->render(),
                        $response->getContent()
                    ));
                }
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
            
            if(isset($matches[0])){
                $response->setContent(str_replace(
                    $matches[0],
                    $view->render(),
                    $response->getContent()
                ));
            }
        } else {
            foreach ($this->htmlTag as $key => $tag) {
                $content    = $response->getContent();
                $regex      = "#<\s*?{$tag}\b[^>]*>(.*?)</{$tag}\b[^>]*>#s";
                $view       = view($this->realTimeView[$key]);
                preg_match($regex, $content, $matches);
                
                if(isset($matches[0])){
                    $response->setContent(str_replace(
                        $matches[0],
                        $view->render(),
                        $response->getContent()
                    ));
                }
            }
        }
    }
}
