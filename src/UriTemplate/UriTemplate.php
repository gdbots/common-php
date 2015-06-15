<?php

namespace Gdbots\UriTemplate;

interface UriTemplate
{
    /**
     * Expand the URI template using the supplied variables
     *
     * @param string $template  URI Template to expand
     * @param array  $variables Variables to use with the expansion
     *
     * @return string Returns the expanded template
     */
    public function expand($template, array $variables);
}
