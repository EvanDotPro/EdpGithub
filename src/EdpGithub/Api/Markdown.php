<?php

namespace EdpGithub\Api;

class Markdown extends AbstractApi
{
    /**
     * Render a Markdown document
     *
     * @link http://developer.github.com/v3/markdown/
     *
     * @param  string $text
     * @return string
     */
    public function render($text)
    {
        $parameters = array(
               "text" => $text,
          );

        return $this->post('markdown', $parameters);
    }
}
