<?php

namespace Gdbots\UriTemplate;

class UriTemplateService
{
    /**
     * The parser/expander of uri templates.
     * @var UriTemplate
     */
    protected static $provider;

    /**
     * All the available uri templates keyed by an id.
     * @link http://tools.ietf.org/html/rfc6570
     * @var string[]
     */
    protected static $templates = [];

    /**
     * Variables that will be merged with all expand requests.  Useful
     * for having a "site_base_url" variable that is expanded on all
     * templates that have internal urls.
     * @var array
     */
    protected static $globalVariables = [];

    /**
     * Expand the URI template (the id) using the supplied variables
     *
     * @param string $id  URI Template to expand
     * @param array  $variables Variables to use with the expansion
     *
     * @return string Returns the expanded template
     */
    public static function expand($id, array $variables = [])
    {
        if (!self::hasTemplate($id)) {
            return null;
        }
        $variables = array_merge(self::$globalVariables, $variables);
        return self::getProvider()->expand(self::$templates[$id], $variables);
    }

    /**
     * @param UriTemplate $provider
     */
    public static function setProvider(UriTemplate $provider)
    {
        self::$provider = $provider;
    }

    /**
     * @return UriTemplate
     */
    public static function getProvider()
    {
        if (null === self::$provider) {
            self::$provider = new GuzzleUriTemplate();
        }
        return self::$provider;
    }

    /**
     * @param string $id
     * @return bool
     */
    public static function hasTemplate($id)
    {
        return isset(self::$templates[$id]);
    }

    /**
     * Registers a new uri template or overrides an existing one.
     *
     * @param string $id
     * @param string $template
     */
    public static function registerTemplate($id, $template)
    {
        self::$templates[$id] = $template;
    }

    /**
     * Registers an array of id => uri template values to the service.  e.g.:
     * ['youtube:video.canonical' => 'https://www.youtube.com/watch?v={youtube_video_id}']
     *
     * @param array $templates
     */
    public static function registerTemplates(array $templates)
    {
        if (empty(self::$templates)) {
            self::$templates = $templates;
            return;
        }
        self::$templates = array_merge(self::$templates, $templates);
    }

    /**
     * Registers a global variable that will be merged with all expand requests.
     * Will override the current value if it exists.
     *
     * @param string $name
     * @param mixed $value
     */
    public static function registerGlobal($name, $value)
    {
        self::$globalVariables[$name] = $value;
    }

    /**
     * Registers an associative array of global variables.  These get merged into
     * the variables array of all expand requests.
     *
     * @param array $globalVariables
     */
    public static function registerGlobals(array $globalVariables)
    {
        if (empty(self::$globalVariables)) {
            self::$globalVariables = $globalVariables;
            return;
        }
        self::$globalVariables = array_merge(self::$globalVariables, $globalVariables);
    }
}
