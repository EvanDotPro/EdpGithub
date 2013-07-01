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
     * @param  string $mode
     * @param  string $context
     * @return string
     */
    public function render($text, $mode = '', $context = '')
    {
          $parameters = array(
               "text" => $text,
          );
          return $this->post('markdown', $parameters);
    }
}
